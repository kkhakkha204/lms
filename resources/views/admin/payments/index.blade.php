@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Orders Management</h1>
                <p class="text-gray-600 mt-1">Manage all payment transactions and orders</p>
            </div>
            <div class="flex space-x-4">
                <button onclick="exportPayments()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_revenue'], 0, ',', '.') }} VND</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Completed Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_payments'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_payments'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avg Order Value</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['average_order_value'], 0, ',', '.') }} VND</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <form method="GET" action="{{ route('admin.payments.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Transaction ID, Student, Course..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="all">All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- Payment Method Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <select name="payment_method" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="all">All Methods</option>
                            <option value="stripe" {{ request('payment_method') === 'stripe' ? 'selected' : '' }}>Stripe</option>
                            <option value="paypal" {{ request('payment_method') === 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="bank_transfer" {{ request('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.payments.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'transaction_id', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-gray-700">
                                Transaction ID
                                @if(request('sort_by') === 'transaction_id')
                                    <span class="ml-1">{{ request('sort_order') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'final_amount', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-gray-700">
                                Amount
                                @if(request('sort_by') === 'final_amount')
                                    <span class="ml-1">{{ request('sort_order') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-gray-700">
                                Date
                                @if(request('sort_by') === 'created_at')
                                    <span class="ml-1">{{ request('sort_order') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $payment->transaction_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $payment->student->name }}</div>
                                <div class="text-sm text-gray-500">{{ $payment->student->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($payment->course->title, 30) }}</div>
                                <div class="text-sm text-gray-500">ID: {{ $payment->course->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ number_format($payment->final_amount, 0, ',', '.') }} {{ $payment->currency }}</div>
                                @if($payment->discount_amount > 0)
                                    <div class="text-sm text-green-600">-{{ number_format($payment->discount_amount, 0, ',', '.') }} VND</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ ucfirst($payment->payment_method) }}
                            </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                        'refunded' => 'bg-orange-100 text-orange-800',
                                        'cancelled' => 'bg-gray-100 text-gray-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$payment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $payment->created_at->format('M d, Y') }}</div>
                                <div>{{ $payment->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="viewPaymentDetails({{ $payment->id }})"
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                    View
                                </button>
                                @if(in_array($payment->status, ['pending', 'failed']))
                                    <button onclick="updatePaymentStatus({{ $payment->id }}, 'completed')"
                                            class="text-green-600 hover:text-green-900 mr-3">
                                        Complete
                                    </button>
                                @endif
                                @if($payment->status === 'completed')
                                    <button onclick="updatePaymentStatus({{ $payment->id }}, 'refunded')"
                                            class="text-orange-600 hover:text-orange-900">
                                        Refund
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                No payments found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($payments->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Payment Details Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Payment Details</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="paymentDetails">
                <!-- Payment details will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Update Payment Status</h3>
                <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="statusUpdateForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">New Status</label>
                    <select id="newStatus" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="failed">Failed</option>
                        <option value="refunded">Refunded</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason (Optional)</label>
                    <textarea id="statusReason" rows="3" placeholder="Enter reason for status change..."
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div class="flex space-x-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Update Status
                    </button>
                    <button type="button" onclick="closeStatusModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentPaymentId = null;

        function viewPaymentDetails(paymentId) {
            fetch(`/admin/payments/${paymentId}`)
                .then(response => response.json())
                .then(data => {
                    displayPaymentDetails(data);
                    document.getElementById('paymentModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading payment details');
                });
        }

        function displayPaymentDetails(data) {
            const payment = data.payment;
            const timeline = data.timeline;
            const paymentDetails = data.formatted_payment_details;

            const html = `
        <div class="space-y-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold text-gray-900 mb-2">Transaction Information</h4>
                    <div class="space-y-2 text-sm">
                        <div><span class="font-medium">Transaction ID:</span> ${payment.transaction_id}</div>
                        <div><span class="font-medium">Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusColor(payment.status)}">
                                ${payment.status.charAt(0).toUpperCase() + payment.status.slice(1)}
                            </span>
                        </div>
                        <div><span class="font-medium">Payment Method:</span> ${payment.payment_method.charAt(0).toUpperCase() + payment.payment_method.slice(1)}</div>
                        <div><span class="font-medium">Currency:</span> ${payment.currency}</div>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-2">Amount Details</h4>
                    <div class="space-y-2 text-sm">
                        <div><span class="font-medium">Original Amount:</span> ${formatCurrency(payment.amount)} ${payment.currency}</div>
                        <div><span class="font-medium">Discount:</span> ${formatCurrency(payment.discount_amount)} ${payment.currency}</div>
                        <div><span class="font-medium">Final Amount:</span> <span class="text-lg font-bold">${formatCurrency(payment.final_amount)} ${payment.currency}</span></div>
                    </div>
                </div>
            </div>

            <!-- Student Information -->
            <div>
                <h4 class="font-semibold text-gray-900 mb-2">Student Information</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><span class="font-medium">Name:</span> ${payment.student.name}</div>
                        <div><span class="font-medium">Email:</span> ${payment.student.email}</div>
                        <div><span class="font-medium">Phone:</span> ${payment.student.phone || 'N/A'}</div>
                        <div><span class="font-medium">Status:</span> ${payment.student.is_active ? 'Active' : 'Inactive'}</div>
                    </div>
                </div>
            </div>

            <!-- Course Information -->
            <div>
                <h4 class="font-semibold text-gray-900 mb-2">Course Information</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm space-y-2">
                        <div><span class="font-medium">Title:</span> ${payment.course.title}</div>
                        <div><span class="font-medium">Price:</span> ${formatCurrency(payment.course.price)} ${payment.currency}</div>
                        <div><span class="font-medium">Level:</span> ${payment.course.level.charAt(0).toUpperCase() + payment.course.level.slice(1)}</div>
                        <div><span class="font-medium">Status:</span> ${payment.course.status.charAt(0).toUpperCase() + payment.course.status.slice(1)}</div>
                    </div>
                </div>
            </div>

            <!-- Payment Timeline -->
            ${timeline.length > 0 ? `
            <div>
                <h4 class="font-semibold text-gray-900 mb-2">Payment Timeline</h4>
                <div class="space-y-3">
                    ${timeline.map(item => `
                        <div class="flex items-start space-x-3">
                            <div class="w-3 h-3 rounded-full mt-1 ${getTimelineColor(item.status)}"></div>
                            <div class="flex-1">
                                <div class="font-medium text-sm">${item.title}</div>
                                <div class="text-xs text-gray-500">${item.description}</div>
                                <div class="text-xs text-gray-400">${formatDate(item.date)}</div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>
            ` : ''}

            <!-- Payment Gateway Details -->
            ${paymentDetails.length > 0 ? `
            <div>
                <h4 class="font-semibold text-gray-900 mb-2">Payment Gateway Details</h4>
                <div class="bg-gray-50 p-4 rounded-lg max-h-40 overflow-y-auto">
                    <div class="space-y-2 text-sm">
                        ${paymentDetails.map(detail => `
                            <div><span class="font-medium">${detail.key}:</span> ${detail.value}</div>
                        `).join('')}
                    </div>
                </div>
            </div>
            ` : ''}

            <!-- Failure Reason -->
            ${payment.failure_reason ? `
            <div>
                <h4 class="font-semibold text-gray-900 mb-2">Failure Reason</h4>
                <div class="bg-red-50 border border-red-200 p-4 rounded-lg">
                    <p class="text-sm text-red-700">${payment.failure_reason}</p>
                </div>
            </div>
            ` : ''}
        </div>
    `;

            document.getElementById('paymentDetails').innerHTML = html;
        }

        function updatePaymentStatus(paymentId, newStatus) {
            currentPaymentId = paymentId;
            document.getElementById('newStatus').value = newStatus;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        document.getElementById('statusUpdateForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const newStatus = document.getElementById('newStatus').value;
            const reason = document.getElementById('statusReason').value;

            fetch(`/admin/payments/${currentPaymentId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: newStatus,
                    reason: reason
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Payment status updated successfully');
                        location.reload();
                    } else {
                        alert('Error updating payment status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating payment status');
                });
        });

        function exportPayments() {
            const url = new URL(window.location);
            url.pathname = '/admin/payments/export';
            window.location.href = url.toString();
        }

        function closeModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
            document.getElementById('statusReason').value = '';
        }

        // Utility functions
        function getStatusColor(status) {
            const colors = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'completed': 'bg-green-100 text-green-800',
                'failed': 'bg-red-100 text-red-800',
                'refunded': 'bg-orange-100 text-orange-800',
                'cancelled': 'bg-gray-100 text-gray-800'
            };
            return colors[status] || 'bg-gray-100 text-gray-800';
        }

        function getTimelineColor(status) {
            const colors = {
                'info': 'bg-blue-400',
                'success': 'bg-green-400',
                'error': 'bg-red-400',
                'warning': 'bg-yellow-400'
            };
            return colors[status] || 'bg-gray-400';
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount);
        }

        function formatDate(dateString) {
            return new Date(dateString).toLocaleString('vi-VN');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const paymentModal = document.getElementById('paymentModal');
            const statusModal = document.getElementById('statusModal');

            if (event.target === paymentModal) {
                closeModal();
            }
            if (event.target === statusModal) {
                closeStatusModal();
            }
        }
    </script>
@endsection
