<script>
  let mobileMenuOpen = $state(false);
</script>

<header class="bg-card shadow-sm border-b border-border">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <!-- Logo -->
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <h1 class="text-xl font-bold text-primary">InnovaHub</h1>
        </div>
      </div>

      <!-- Desktop Navigation -->
      <nav class="hidden md:block">
        <div class="ml-10 flex items-baseline space-x-8">
          <a href="/" class="text-muted hover:text-primary px-3 py-2 text-sm font-medium transition-colors">
            Beranda
          </a>
          <a href="/explore" class="text-muted hover:text-primary px-3 py-2 text-sm font-medium transition-colors">
            Jelajahi Ide
          </a>
          <a href="/about" class="text-muted hover:text-primary px-3 py-2 text-sm font-medium transition-colors">
            Tentang
          </a>
          <a href="/submit" class="bg-accent text-accent-foreground px-4 py-2 rounded-lg text-sm font-medium hover:bg-accent/90 transition-colors">
            Submit Ide
          </a>
        </div>
      </nav>

      <!-- Mobile menu button -->
      <div class="md:hidden">
        <button
          aria-label="Toggle mobile menu"
          onclick={() => mobileMenuOpen = !mobileMenuOpen}
          class="text-muted hover:text-primary p-2"
        >
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Navigation -->
    {#if mobileMenuOpen}
      <div class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t border-border">
          <a href="/" class="text-muted hover:text-primary block px-3 py-2 text-base font-medium">
            Beranda
          </a>
          <a href="/explore" class="text-muted hover:text-primary block px-3 py-2 text-base font-medium">
            Jelajahi Ide
          </a>
          <a href="/about" class="text-muted hover:text-primary block px-3 py-2 text-base font-medium">
            Tentang
          </a>
          <a href="/submit" class="bg-accent text-accent-foreground block px-3 py-2 rounded-lg text-base font-medium">
            Submit Ide
          </a>
        </div>
      </div>
    {/if}
  </div>
</header>
