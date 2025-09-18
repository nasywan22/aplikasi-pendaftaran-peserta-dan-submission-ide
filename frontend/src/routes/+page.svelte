<script>
  import Header from '../lib/components/Navbar.svelte';
  import HeroSection from '../lib/components/HeroSection.svelte';
  import FeaturesSection from '../lib/components/FeaturesSection.svelte';
  import Footer from '../lib/components/Footer.svelte';
</script>

<div class="min-h-screen bg-background">
  <Header />
  <main>
    <HeroSection />
    <FeaturesSection />
  </main>
  <Footer />
</div>
