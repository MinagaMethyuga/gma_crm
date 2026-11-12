<?php

use App\Enums\UserRole;
use App\Models\CommunityGroup;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function gmaPlan(): Plan
{
    return Plan::firstOrCreate(
        ['slug' => 'professional'],
        [
            'name' => 'Professional',
            'stripe_product_id' => 'prod_community_test',
            'stripe_price_id' => 'price_community_test',
            'price' => 99,
            'billing_period' => 'yearly',
        ]
    );
}

function memberUser(array $overrides = []): User
{
    return User::factory()->create(array_merge([
        'plan_id' => gmaPlan()->id,
        'plan_subscribed_at' => now()->subMonth(),
        'role' => UserRole::Member,
    ], $overrides));
}

function adminUser(): User
{
    return memberUser(['role' => UserRole::Admin]);
}

/**
 * A real 32x32 PNG, built without the GD extension so the suite runs anywhere.
 */
function pngBytes(): string
{
    return base64_decode(
        'iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAzSURBVFhH7c6hAQAwCMAwzsLz/Z4angPARNRUJSrfvyzm2A4AAAAAAAAAAAAAAAAAAKABzAEQiMPnMF0AAAAASUVORK5CYII='
    );
}

function pngUpload(string $name = 'logo.png'): UploadedFile
{
    return UploadedFile::fake()->createWithContent($name, pngBytes());
}

function publishGroup(User $creator, array $overrides = []): CommunityGroup
{
    $group = CommunityGroup::create(array_merge([
        'name' => 'Published Group',
        'category' => 'networking',
        'description' => 'A group that is already live.',
        'join_method' => CommunityGroup::JOIN_OPEN,
        'status' => CommunityGroup::STATUS_APPROVED,
        'created_by' => $creator->id,
    ], $overrides));

    $group->members()->attach($creator->id, ['role' => 'admin', 'joined_at' => now()]);

    return $group;
}

test('members see the discover page with popular communities', function () {
    $user = memberUser();
    $other = memberUser();

    publishGroup($other, ['name' => 'Payments Founders', 'status' => CommunityGroup::STATUS_APPROVED]);
    publishGroup($other, ['name' => 'DeepTech Builders', 'status' => CommunityGroup::STATUS_APPROVED]);

    $this->actingAs($user)
        ->get(route('member.community'))
        ->assertOk()
        ->assertSee('Find your people')
        ->assertSee('Popular right now')
        ->assertSee('Payments Founders')
        ->assertSee('DeepTech Builders')
        // Visual scaffolding: ambient reveal, animated hero, and count-up stats.
        ->assertSee('page-aurora', false)
        ->assertSee('hero-surface', false)
        ->assertSee('reveal', false)
        ->assertSee('data-count-to', false)
        ->assertSee('section-accent', false);
});

test('members can submit a community and it starts unpublished', function () {
    $user = memberUser();

    $response = $this->actingAs($user)->post(route('member.community.store'), [
        'name' => 'Payments Founders',
        'category' => 'startups',
        'description' => 'A room for payments founders.',
    ]);

    $group = CommunityGroup::where('name', 'Payments Founders')->firstOrFail();

    $response->assertRedirect(route('member.community'));
    $this->assertSame(CommunityGroup::STATUS_PENDING, $group->status);
    $this->assertSame(CommunityGroup::JOIN_OPEN, $group->join_method);
    $this->assertTrue($group->members()->whereKey($user->id)->exists());
    $this->assertSame('admin', $group->members()->find($user->id)->pivot->role);
});

test('a pending community is hidden from other members but visible to its creator', function () {
    $creator = memberUser();
    $bystander = memberUser();

    $this->actingAs($creator)->post(route('member.community.store'), ['name' => 'Secret Lab'])->assertRedirect();
    $this->flushSession();

    $this->actingAs($bystander)
        ->get(route('member.community'))
        ->assertOk()
        ->assertDontSee('Secret Lab');

    $this->actingAs($creator)
        ->get(route('member.community'))
        ->assertOk()
        ->assertSee('Secret Lab')
        ->assertSee('Awaiting approval')
        ->assertDontSee('Leave Group');

    $this->actingAs($creator)
        ->post(route('member.community.leave', CommunityGroup::where('name', 'Secret Lab')->firstOrFail()))
        ->assertRedirect(route('member.community'))
        ->assertSessionHas('error');
});

test('members cannot join a community that is not published', function () {
    $creator = memberUser();
    $bystander = memberUser();

    $group = CommunityGroup::create([
        'name' => 'Draft Room',
        'join_method' => CommunityGroup::JOIN_OPEN,
        'status' => CommunityGroup::STATUS_PENDING,
        'created_by' => $creator->id,
    ]);

    $this->actingAs($bystander)
        ->post(route('member.community.join', $group))
        ->assertRedirect(route('member.community'))
        ->assertSessionHas('error');

    $this->assertFalse($group->members()->whereKey($bystander->id)->exists());
});

test('admins publishing a submission makes it discoverable', function () {
    $creator = memberUser();
    $admin = adminUser();

    $this->actingAs($creator)->post(route('member.community.store'), ['name' => 'Design Guild'])->assertRedirect();

    $group = CommunityGroup::where('name', 'Design Guild')->firstOrFail();
    $this->assertSame(CommunityGroup::STATUS_PENDING, $group->status);

    $this->actingAs($admin)
        ->from(route('admin.community'))
        ->post(route('admin.community.groups.approve', $group))
        ->assertRedirect(route('admin.community'));

    $this->assertSame(CommunityGroup::STATUS_APPROVED, $group->fresh()->status);

    $this->actingAs(memberUser())
        ->get(route('member.community'))
        ->assertOk()
        ->assertSee('Design Guild');
});

test('members are capped at three communities', function () {
    $user = memberUser();

    foreach (range(1, 3) as $n) {
        $this->actingAs($user)
            ->post(route('member.community.store'), ['name' => "My Group $n"])
            ->assertRedirect(route('member.community'));
    }

    $this->assertSame(3, CommunityGroup::where('created_by', $user->id)->count());

    $this->actingAs($user)
        ->post(route('member.community.store'), ['name' => 'One Too Many'])
        ->assertRedirect(route('member.community'))
        ->assertSessionHas('error');

    $this->assertNull(CommunityGroup::where('name', 'One Too Many')->first());
});

test('duplicate community names are rejected', function () {
    $user = memberUser();

    publishGroup($user, ['name' => 'Payments Founders']);

    $this->actingAs($user)
        ->post(route('member.community.store'), ['name' => 'Payments Founders'])
        ->assertRedirect(route('member.community'))
        ->assertSessionHas('error');

    $this->assertSame(1, CommunityGroup::where('name', 'Payments Founders')->count());
});

test('community creation requires a name', function () {
    $user = memberUser();

    $this->actingAs($user)
        ->post(route('member.community.store'), ['name' => ''])
        ->assertSessionHasErrors('name');

    $this->assertSame(0, CommunityGroup::count());
});

test('guests cannot create communities', function () {
    $this->post(route('member.community.store'), ['name' => 'Nope'])
        ->assertRedirect(route('login'));

    $this->assertSame(0, CommunityGroup::count());
});

test('unknown category values are rejected', function () {
    $user = memberUser();

    $this->actingAs($user)
        ->post(route('member.community.store'), [
            'name' => 'Sneaky Group',
            'category' => 'not-a-real-category',
        ])
        ->assertSessionHasErrors('category');

    $this->assertSame(0, CommunityGroup::count());
});

test('community names containing control characters or markup are rejected', function () {
    $user = memberUser();

    $this->actingAs($user)
        ->post(route('member.community.store'), ['name' => "Bad\x00Name"])
        ->assertSessionHasErrors('name');

    $this->actingAs($user)
        ->post(route('member.community.store'), ['name' => '<script>alert(1)</script>'])
        ->assertSessionHasErrors('name');

    $this->assertSame(0, CommunityGroup::count());
});

test('description markup and control characters are stripped before saving', function () {
    $user = memberUser();

    $this->actingAs($user)->post(route('member.community.store'), [
        'name' => 'Clean Room',
        'description' => "<b>Hello</b> world\x01",
    ])->assertRedirect();

    $group = CommunityGroup::where('name', 'Clean Room')->firstOrFail();
    $this->assertSame('Hello world', $group->description);
});

test('logo uploads must be a real raster image under 2MB', function () {
    Storage::fake('public');
    $user = memberUser();

    $this->actingAs($user)
        ->post(route('member.community.store'), [
            'name' => 'Fake Logo',
            'logo' => UploadedFile::fake()->createWithContent('payload.php', '<?php echo "pwned";'),
        ])
        ->assertSessionHasErrors('logo');

    $this->actingAs($user)
        ->post(route('member.community.store'), [
            'name' => 'Too Big',
            'logo' => UploadedFile::fake()->createWithContent('big.png', pngBytes().str_repeat('A', 3 * 1024 * 1024)),
        ])
        ->assertSessionHasErrors('logo');

    $this->assertSame(0, CommunityGroup::count());
});

test('a valid logo is stored on the public disk', function () {
    Storage::fake('public');
    $user = memberUser();

    $this->actingAs($user)->post(route('member.community.store'), [
        'name' => 'With Logo',
        'logo' => pngUpload(),
    ])->assertRedirect();

    $group = CommunityGroup::where('name', 'With Logo')->firstOrFail();

    $this->assertNotNull($group->logo);
    Storage::disk('public')->assertExists($group->logo);
});

test('community creation is rate limited', function () {
    $user = memberUser();

    foreach (range(1, 5) as $n) {
        $this->actingAs($user)
            ->post(route('member.community.store'), ['name' => "Rate Group $n"])
            ->assertRedirect(route('member.community'));
    }

    $this->actingAs($user)
        ->post(route('member.community.store'), ['name' => 'Rate Group 6'])
        ->assertStatus(429);
});

test('admin community page renders the group table with edit data', function () {
    $creator = memberUser();
    publishGroup($creator, ['name' => 'Rendered Group']);

    $this->actingAs(adminUser())
        ->get(route('admin.community'))
        ->assertOk()
        ->assertSee('Rendered Group')
        ->assertSee('data-group=', false);
});
