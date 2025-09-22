<script lang="ts">
	// svelte tools
	import { onMount } from 'svelte';

	// shadcn
	import * as Dropdown from '$lib/components/ui/dropdown-menu/index';
	import * as Avatar from '$lib/components/ui/avatar/index.js';
	import Button from './ui/button/button.svelte';
	import { buttonVariants } from '$lib/components/ui/button';

	// icons
	import Icon from '@iconify/svelte';

	// types
	interface propsTypes {
		user?: {
			nama?: string;
			email?: string;
		};
	}

	// props
	const props: propsTypes = $props();

	// state
	let mobileMenuOpen = $state<boolean>(false);
	let pathSaatIni = $state<string>();
	const namaUser = $state<string>(props.user?.nama ?? '');

	// lifecycle
	onMount(() => {
		pathSaatIni = ambilPathSaatIni();
	});

	// functions
	const ambilPathSaatIni = (): string => {
		const path: string[] = window.location.pathname.split('/');
		const pathSaatIni: string = path[path.length - 1];
		return pathSaatIni;
	};
</script>

<header class="bg-card border-border border-b shadow-sm">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="flex h-16 items-center justify-between">
			<!-- Logo -->
			<div class="flex items-center">
				<div class="flex-shrink-0">
					<h1 class="text-primary text-xl font-bold">InnovaHub</h1>
				</div>
			</div>

			<!-- Desktop Navigation -->
			<nav class="hidden md:block">
				<div class="ml-10 flex items-center space-x-8">
					{#if pathSaatIni !== 'formSubmission'}
						<a href="/formSubmission" class={buttonVariants({ variant: 'default' })}>
							Submit Ide
						</a>
					{/if}
					{#if props.user != null}
						<div class="flex flex-row items-center gap-3">
							<!-- avatar -->
							<div>
								<Avatar.Root>
									<Avatar.Image src="https://github.com/shadcn.png" alt="Shadcn" />
									<Avatar.Fallback>SC</Avatar.Fallback>
								</Avatar.Root>
							</div>

							<!-- Nama User -->
							{namaUser}

							<!-- Dropdown -->
							<div class="flex items-center">
								<Dropdown.Root>
									<Dropdown.Trigger>
										<Icon icon="iconamoon:arrow-down-2-light" width="20" height="20" />
									</Dropdown.Trigger>
									<Dropdown.Content>
										<Dropdown.Content>
											<Dropdown.Group>
												<Dropdown.Label>My Account</Dropdown.Label>
												<Dropdown.Separator />
												<Dropdown.Item>Profile</Dropdown.Item>
												<Dropdown.Item>Billing</Dropdown.Item>
												<Dropdown.Item>Team</Dropdown.Item>
												<Dropdown.Item>Subscription</Dropdown.Item>
											</Dropdown.Group>
										</Dropdown.Content>
									</Dropdown.Content>
								</Dropdown.Root>
							</div>
						</div>
					{:else}
						<a
							href="/logReg"
							class="bg-accent text-accent-foreground hover:bg-accent/90 rounded-lg px-4 py-2 text-sm font-medium transition-colors"
						>
							Sign in / Sign up
						</a>
					{/if}
				</div>
			</nav>

			<!-- Mobile menu button -->
			<div class="md:hidden">
				<button
					aria-label="Toggle mobile menu"
					onclick={() => (mobileMenuOpen = !mobileMenuOpen)}
					class="hover:text-primary p-2"
				>
					hamburger
				</button>
			</div>
		</div>

		<!-- Mobile Navigation -->
		{#if mobileMenuOpen}
			<div class="md:hidden">
				<div class="border-border space-y-1 border-t px-2 pb-3 pt-2 sm:px-3">
					<a
						href="/submit"
						class="bg-accent text-accent-foreground block rounded-lg px-3 py-2 text-base font-medium"
					>
						Submit Ide
					</a>
				</div>
			</div>
		{/if}
	</div>
</header>