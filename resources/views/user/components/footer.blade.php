

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const sidebar = document.getElementById('sidebar');

            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (event) => {
                if (window.innerWidth < 1024 && !sidebar.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            });

            // Prevent scroll when sidebar is open on mobile
            const body = document.body;
            new MutationObserver(() => {
                if (window.innerWidth < 1024 && !sidebar.classList.contains('-translate-x-full')) {
                    body.style.overflow = 'hidden';
                } else {
                    body.style.overflow = '';
                }
            }).observe(sidebar, { attributes: true, attributeFilter: ['class'] });

        });
    </script>

</body>
</html>
