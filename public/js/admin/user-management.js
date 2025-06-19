/**
 * User Management JavaScript Functions
 * Shared functions for admin user management
 */

// Modal functions
window.UserManagement = {
    showModal: function() {
        document.getElementById('confirmModal').classList.remove('hidden');
    },

    hideModal: function() {
        document.getElementById('confirmModal').classList.add('hidden');
    },

    showLoading: function() {
        document.getElementById('loadingOverlay').classList.remove('hidden');
    },

    hideLoading: function() {
        document.getElementById('loadingOverlay').classList.add('hidden');
    },

    showNotification: function(message, type = 'success') {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';

        notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    },

    toggleUserStatus: function(userId, userName, isActive) {
        const action = isActive ? 'khóa' : 'mở khóa';
        const iconClass = isActive ? 'fa-lock' : 'fa-unlock';
        const iconColor = isActive ? 'text-red-600' : 'text-green-600';

        document.getElementById('modalIcon').className = `fas ${iconClass} ${iconColor} text-xl`;
        document.getElementById('modalTitle').textContent = `${action.charAt(0).toUpperCase() + action.slice(1)} tài khoản`;
        document.getElementById('modalMessage').textContent = `Bạn có chắc chắn muốn ${action} tài khoản của "${userName}"?`;

        const confirmBtn = document.getElementById('confirmBtn');
        confirmBtn.className = `px-4 py-2 ${isActive ? 'bg-red-600 hover:bg-red-700 focus:ring-red-500' : 'bg-green-600 hover:bg-green-700 focus:ring-green-500'} text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors`;

        confirmBtn.onclick = function() {
            UserManagement.hideModal();
            UserManagement.showLoading();

            fetch(`/admin/users/${userId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    UserManagement.hideLoading();
                    if (data.success) {
                        UserManagement.showNotification(data.message, 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        UserManagement.showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    UserManagement.hideLoading();
                    console.error('Error:', error);
                    UserManagement.showNotification('Có lỗi xảy ra, vui lòng thử lại!', 'error');
                });
        };

        UserManagement.showModal();
    },

    deleteUser: function(userId, userName, redirectToIndex = false) {
        document.getElementById('modalIcon').className = 'fas fa-trash text-red-600 text-xl';
        document.getElementById('modalTitle').textContent = 'Xóa người dùng';
        document.getElementById('modalMessage').textContent = `Bạn có chắc chắn muốn xóa tài khoản của "${userName}"? Thao tác này không thể hoàn tác.`;

        const confirmBtn = document.getElementById('confirmBtn');
        confirmBtn.className = 'px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors';

        confirmBtn.onclick = function() {
            UserManagement.hideModal();
            UserManagement.showLoading();

            fetch(`/admin/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    UserManagement.hideLoading();
                    if (data.success) {
                        UserManagement.showNotification(data.message, 'success');
                        setTimeout(() => {
                            if (redirectToIndex) {
                                window.location.href = '/admin/users';
                            } else {
                                window.location.reload();
                            }
                        }, 1500);
                    } else {
                        UserManagement.showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    UserManagement.hideLoading();
                    console.error('Error:', error);
                    UserManagement.showNotification('Có lỗi xảy ra, vui lòng thử lại!', 'error');
                });
        };

        UserManagement.showModal();
    },

    initializeEventListeners: function() {
        // Cancel button
        const cancelBtn = document.getElementById('cancelBtn');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', UserManagement.hideModal);
        }

        // Close modal when clicking outside
        const confirmModal = document.getElementById('confirmModal');
        if (confirmModal) {
            confirmModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    UserManagement.hideModal();
                }
            });
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                UserManagement.hideModal();
            }
        });
    }
};

// Global functions for backward compatibility
window.showModal = UserManagement.showModal;
window.hideModal = UserManagement.hideModal;
window.showLoading = UserManagement.showLoading;
window.hideLoading = UserManagement.hideLoading;
window.showNotification = UserManagement.showNotification;
window.toggleUserStatus = UserManagement.toggleUserStatus;
window.deleteUser = function(userId, userName) {
    // Check if we're on the show page by looking for specific elements
    const isShowPage = window.location.pathname.includes('/admin/users/') &&
        !window.location.pathname.includes('/edit');
    UserManagement.deleteUser(userId, userName, isShowPage);
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    UserManagement.initializeEventListeners();
});
