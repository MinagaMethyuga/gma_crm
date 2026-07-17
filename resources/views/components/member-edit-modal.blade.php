<div id="member-edit-modal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeMemberEditModal()"></div>

    <div class="fixed inset-0 flex items-center justify-center p-4" style="pointer-events: none;">
        <div id="member-edit-modal-content" class="bg-white rounded-2xl shadow-2xl w-full overflow-hidden transition-all" style="max-width: 60vw; max-height: 90vh; pointer-events: auto;">
            <div class="flex flex-col" style="max-height: 90vh;">
                <!-- Header -->
                <div class="flex items-center justify-between px-8 py-5 border-b border-slate-200 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#4338ca]/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#4338ca]">edit_square</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Edit Member</h3>
                            <p class="text-[13px] text-slate-500" id="member-edit-subtitle">Update member details and plan</p>
                        </div>
                    </div>
                    <button onclick="closeMemberEditModal()" class="w-9 h-9 rounded-full hover:bg-slate-100 flex items-center justify-center transition-colors">
                        <span class="material-symbols-outlined text-slate-500">close</span>
                    </button>
                </div>

                <!-- Scrollable Body -->
                <div class="flex-1 overflow-y-auto px-8 py-6 custom-scroll">
                    <form id="member-edit-form" onsubmit="return false;">
                        @csrf
                        <input type="hidden" id="edit-user-id" name="user_id" value="">

                        <!-- Summary Card -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-100 rounded-xl p-5 mb-8">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-full bg-white overflow-hidden shrink-0 border-2 border-indigo-200 shadow-sm">
                                    <img id="edit-avatar" src="" alt="" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-[15px] font-bold text-slate-900" id="edit-name-display"></h4>
                                        <span id="edit-status-badge" class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide"></span>
                                    </div>
                                    <p class="text-[13px] text-slate-500 mt-0.5" id="edit-email-display"></p>
                                    <p class="text-[12px] text-slate-400 mt-0.5">
                                        Referred by: <span id="edit-referred-by" class="font-medium text-slate-600"></span>
                                        &middot; <span id="edit-joined-date"></span>
                                        &middot; Tier: <span id="edit-tier-display" class="font-semibold text-indigo-600"></span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Fields -->
                        <div class="mb-8">
                            <h4 class="text-[13px] font-bold text-slate-500 uppercase tracking-wider mb-4">Profile Information</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="edit-name" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Full Name</label>
                                    <input type="text" id="edit-name" name="name" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" required>
                                </div>
                                <div>
                                    <label for="edit-company" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Company</label>
                                    <input type="text" id="edit-company" name="company_name" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow">
                                </div>
                                <div>
                                    <label for="edit-phone" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Phone</label>
                                    <input type="text" id="edit-phone" name="phone" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow">
                                </div>
                                <div>
                                    <label for="edit-email" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Email</label>
                                    <input type="email" id="edit-email" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-500 bg-slate-50 cursor-not-allowed" readonly disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Plan + Payment Section -->
                        <div class="mb-6">
                            <h4 class="text-[13px] font-bold text-slate-500 uppercase tracking-wider mb-4">Plan Assignment & Payment</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="edit-plan" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Plan</label>
                                    <div class="relative">
                                        <select id="edit-plan" name="plan_id" class="appearance-none w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow bg-white">
                                            <option value="">No Plan</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                            <span class="material-symbols-outlined text-[18px]">expand_more</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="edit-plan-period" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Period</label>
                                    <div class="relative">
                                        <select id="edit-plan-period" name="plan_period" class="appearance-none w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow bg-white">
                                            <option value="monthly">Monthly</option>
                                            <option value="yearly">Yearly</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                            <span class="material-symbols-outlined text-[18px]">expand_more</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="edit-invoice-number" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Invoice Number</label>
                                    <input type="text" id="edit-invoice-number" name="invoice_number" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" placeholder="e.g. INV-001">
                                </div>
                                <div>
                                    <label for="edit-payment-method" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Payment Method</label>
                                    <input type="text" id="edit-payment-method" name="payment_method" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow" placeholder="e.g. Cash, Bank Transfer">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="edit-notes" class="block text-[13px] font-semibold text-slate-700 mb-1.5">Notes</label>
                                <textarea id="edit-notes" name="notes" rows="3" class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-[14px] font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-[#4338ca] focus:border-[#4338ca] transition-shadow resize-none" placeholder="Additional notes..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-end gap-3 px-8 py-4 border-t border-slate-200 bg-slate-50/50 shrink-0">
                    <button onclick="closeMemberEditModal()" class="px-5 py-2.5 rounded-lg text-[13px] font-bold text-slate-700 hover:bg-slate-200/70 transition-colors border border-slate-200">
                        Cancel
                    </button>
                    <button onclick="saveMemberEdit()" class="px-6 py-2.5 rounded-lg text-[13px] font-bold text-white bg-[#4338ca] hover:bg-[#3730a3] transition-colors shadow-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">check</span>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let allPlans = [];

function openMemberEditModal(userId) {
    fetch('/members/' + userId + '/edit', {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        const user = data.user;
        allPlans = data.plans;
        const lastValues = data.last_values || {};

        document.getElementById('edit-user-id').value = user.id;
        document.getElementById('edit-avatar').src = user.avatar_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name || 'User') + '&background=103C68&color=fff';
        document.getElementById('edit-avatar').alt = user.name;
        document.getElementById('edit-name-display').textContent = user.name;
        document.getElementById('edit-email-display').textContent = user.email;
        document.getElementById('edit-referred-by').textContent = user.referrer ? user.referrer.name : 'None';
        document.getElementById('edit-joined-date').textContent = user.created_at ? new Date(user.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : 'N/A';

        const statusBadge = document.getElementById('edit-status-badge');
        if (user.plan_id) {
            statusBadge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-emerald-50 text-emerald-700 border border-emerald-200/60';
            statusBadge.innerHTML = '<span class="w-1 h-1 rounded-full bg-emerald-500"></span> Active';
        } else {
            statusBadge.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-amber-50 text-amber-700 border border-amber-200/60';
            statusBadge.innerHTML = '<span class="w-1 h-1 rounded-full bg-amber-500"></span> Pending';
        }

        document.getElementById('edit-tier-display').textContent = user.plan ? user.plan.name : 'No Plan';

        // Profile fields
        document.getElementById('edit-name').value = user.name || '';
        document.getElementById('edit-company').value = user.company_name || '';
        document.getElementById('edit-phone').value = user.phone || '';
        document.getElementById('edit-email').value = user.email || '';

        // Plan select
        const planSelect = document.getElementById('edit-plan');
        planSelect.innerHTML = '<option value="">No Plan</option>';
        data.plans.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = p.name;
            if (user.plan_id && user.plan_id == p.id) opt.selected = true;
            planSelect.appendChild(opt);
        });

        document.getElementById('edit-plan-period').value = (data.latest_order && data.latest_order.plan_period) ? data.latest_order.plan_period : 'monthly';

        // Invoice fields - populate from last_values (most recent non-null per field)
        document.getElementById('edit-invoice-number').value = lastValues.invoice_number || '';
        document.getElementById('edit-payment-method').value = lastValues.payment_method || '';
        document.getElementById('edit-notes').value = lastValues.notes || '';

        // Show modal
        document.getElementById('member-edit-modal').classList.remove('hidden');
    })
    .catch(err => {
        console.error('Failed to load member data:', err);
        alert('Could not load member details. Please try again.');
    });
}

function closeMemberEditModal() {
    document.getElementById('member-edit-modal').classList.add('hidden');
}

function saveMemberEdit() {
    const userId = document.getElementById('edit-user-id').value;
    if (!userId) return;

    const form = document.getElementById('member-edit-form');
    const formData = new FormData(form);

    formData.append('_method', 'PUT');
    formData.append('plan_id', formData.get('plan_id') || '');

    const submitBtn = document.querySelector('#member-edit-modal-content button[onclick="saveMemberEdit()"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span> Saving...';

    fetch('/members/' + userId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Save failed');
        return data;
    })
    .then(() => {
        closeMemberEditModal();
        window.location.reload();
    })
    .catch(err => {
        console.error('Save failed:', err);
        alert('Failed to save: ' + err.message);
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}
</script>
