<script>
	// import milik sendiri
	import Navbar from '$lib/components/Navbar.svelte';

	let profile = $state({
		name: 'John Doe',
		email: 'john.doe@example.com',
		bio: 'Software developer passionate about creating clean, efficient solutions.',
		location: 'San Francisco, CA',
		website: 'https://johndoe.dev',
		github: 'johndoe',
		twitter: 'johndoe'
	});
</script>

<div class="bg-background min-h-screen">
	<!-- navbar -->
	<Navbar />

	<div class="mx-auto max-w-6xl p-6">
		<!-- Header -->
		<div class="mb-8">
			<h1 class="text-foreground mb-2 text-3xl font-bold">Profile Settings</h1>
			<p class="text-muted-foreground">Manage your account settings and preferences</p>
		</div>

		<div class="flex gap-8">
			<!-- Main Content -->
			<div class="flex-1">
				<div class="bg-card border-border rounded-lg border p-6">
					<h2 class="text-card-foreground mb-6 text-xl font-semibold">Profile Information</h2>

					<div class="space-y-6">
						<!-- Profile Picture -->
						<div class="flex items-center gap-4">
							<div class="bg-muted flex h-20 w-20 items-center justify-center rounded-full">
								<svg
									class="text-muted-foreground h-8 w-8"
									fill="none"
									stroke="currentColor"
									viewBox="0 0 24 24"
								>
									<path
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
									/>
								</svg>
							</div>
							<div>
								<button
									class="bg-primary text-primary-foreground hover:bg-primary/90 rounded-lg px-4 py-2 transition-colors"
								>
									Change Photo
								</button>
								<p class="text-muted-foreground mt-1 text-sm">JPG, PNG or GIF. Max size 2MB.</p>
							</div>
						</div>

						<!-- Form Fields -->
						<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
							<div>
								<label for="fullName" class="text-foreground mb-2 block text-sm font-medium"
									>Full Name</label
								>
								<input
									id="fullName"
									bind:value={profile.name}
									type="text"
									class="bg-input border-border focus:ring-ring text-foreground w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
								/>
							</div>

							<div>
								<label for="email" class="text-foreground mb-2 block text-sm font-medium"
									>Email</label
								>
								<input
									id="email"
									bind:value={profile.email}
									type="email"
									class="bg-input border-border focus:ring-ring text-foreground w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
								/>
							</div>
						</div>

						<div>
							<label for="bio" class="text-foreground mb-2 block text-sm font-medium">Bio</label>
							<textarea
								id="bio"
								bind:value={profile.bio}
								rows="3"
								class="bg-input border-border focus:ring-ring text-foreground w-full resize-none rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
							></textarea>
						</div>

						<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
							<div>
								<label for="location" class="text-foreground mb-2 block text-sm font-medium"
									>Location</label
								>
								<input
									id="location"
									bind:value={profile.location}
									type="text"
									class="bg-input border-border focus:ring-ring text-foreground w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
								/>
							</div>

							<div>
								<label for="website" class="text-foreground mb-2 block text-sm font-medium"
									>Website</label
								>
								<input
									id="website"
									bind:value={profile.website}
									type="url"
									class="bg-input border-border focus:ring-ring text-foreground w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
								/>
							</div>
						</div>

						<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
							<div>
								<label for="github" class="text-foreground mb-2 block text-sm font-medium"
									>GitHub Username</label
								>
								<input
									id="github"
									bind:value={profile.github}
									type="text"
									class="bg-input border-border focus:ring-ring text-foreground w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
								/>
							</div>

							<div>
								<label for="twitter" class="text-foreground mb-2 block text-sm font-medium"
									>Twitter Username</label
								>
								<input
									id="twitter"
									bind:value={profile.twitter}
									type="text"
									class="bg-input border-border focus:ring-ring text-foreground w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2"
								/>
							</div>
						</div>

						<div class="flex justify-end pt-4">
							<button
								class="bg-primary text-primary-foreground hover:bg-primary/90 rounded-lg px-6 py-2 transition-colors"
							>
								Save Changes
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
