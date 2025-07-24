</div> <!-- end main-content -->
</div> <!-- end wrapper -->

<footer class="bg-dark text-white text-center py-3 mt-auto">
  <p class="mb-0">&copy; <?= date("Y") ?> M.S.K College Portal</p>
</footer>

<!-- JS: Theme Toggle -->
<script>
  function toggleTheme() {
    const html = document.documentElement;
    const theme = html.getAttribute("data-bs-theme");
    html.setAttribute("data-bs-theme", theme === "dark" ? "light" : "dark");
  }
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>