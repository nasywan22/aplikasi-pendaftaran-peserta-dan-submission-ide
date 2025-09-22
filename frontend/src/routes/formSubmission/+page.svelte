<script lang="ts">
	// SVELTE tools
	import { onMount } from 'svelte';

	// axios
	import api from '$lib/axiosConfig';
	import type { AxiosResponse } from 'axios';

	// navigation
	import { goto } from '$app/navigation';

	// shadcn
	import {
		Card,
		CardContent,
		CardDescription,
		CardHeader,
		CardTitle
	} from '$lib/components/ui/card';
	import { Button } from '$lib/components/ui/button';
	import { Badge } from '$lib/components/ui/badge';
	import * as AlertDialog from '$lib/components/ui/alert-dialog';

	// icons
	import Icon from '@iconify/svelte';

	// import milik sendiri
	import Navbar from '$lib/components/Navbar.svelte';
	import Sidebar from '$lib/components/Sidebar.svelte';
	import AlertDialogProfilTidakLengkap from '$lib/components/AlertDialogProfilTidakLengkap.svelte';
	import { cekProfilUser } from '$lib/scripts/cekProfilUser';

	// HOOKS DATA
	let user = $state<{
		nama: string;
		email: string;
	}>({
		nama: '',
		email: ''
	});

	// HOOKS/STATE DATA
	let isLoading = $state<boolean>(false);
	let isOpen = $state<boolean>(false);

	// Mock data
	let recentForms = [
		{
			id: 1,
			title: 'Inovasi karya masa depan',
			responses: 142,
			status: 'active',
			lastUpdated: '2 hours ago'
		}
	];

	let stats = [
		{ label: 'Total Forms', value: '12', icon: 'lucide:file-text' },
		{ label: 'Total Responses', value: '1,247', icon: 'lucide:users' },
		{ label: 'Active Forms', value: '8', icon: 'lucide:activity' },
		{ label: 'This Month', value: '342', icon: 'lucide:calendar' }
	];

	let recentActivity = [
		{
			action: 'New response received',
			form: 'Customer Feedback Survey',
			time: '5 minutes ago',
			type: 'response'
		},
		{
			action: 'Form published',
			form: 'Product Registration',
			time: '2 hours ago',
			type: 'publish'
		},
		{ action: 'Form updated', form: 'Employee Onboarding Form', time: '1 day ago', type: 'update' },
		{ action: 'Form created', form: 'Event Registration', time: '3 days ago', type: 'create' }
	];

	// check user account
	// HOOK HANDLERS
	onMount(async () => {
		try {
			await cekAkunUser();
			await cekProfilUser();
		} catch (error) {
			isOpen = true;
		}
	});

	// function
	async function cekAkunUser() {
		try {
			isLoading = true;
			const response: AxiosResponse<any, any, {}> = await api.get('/user');

			const data: {
				nama: string;
				email: string;
			} = {
				nama: response.data.name,
				email: response.data.email
			};

			user = data;
			isLoading = false;
		} catch (error) {
			goto('/logReg?lastPage=formSubmission');
		}
	}
</script>

{#if isLoading}
	<p>Loading...</p>
{:else}
	<!-- Alert Dialog -->
	<AlertDialogProfilTidakLengkap bind:isOpen />

	<div class="bg-background min-h-screen">
		<!-- Header -->
		<Navbar {user} />

		<div class="flex">
			<!-- Sidebar -->
			<Sidebar />

			<!-- Main Content -->
			<main class="flex-1 space-y-6 p-6">
				<!-- welcome -->
				<div class="flex-1">
					<Card>
						<CardContent class="p-6">
							<div class="flex flex-col items-center justify-between">
								<div class="mb-5 flex flex-col items-center justify-center space-y-2">
									<p class="text-foreground text-2xl font-bold">Selamat datang di InnovaHub</p>
									<p class="text-muted-foreground text-sm font-medium">
										Silahkan tekan tombol dibawah ini untuk membuat form
									</p>
								</div>
								<Button class="items-center gap-2" variant="default" onclick={() => goto('/form')}>
									<Icon icon="lucide:plus" class="h-4 w-4" />
									Create New Form
								</Button>
							</div>
						</CardContent>
					</Card>
				</div>

				<!-- Quick Actions -->
				<Card>
					<CardHeader>
						<CardTitle>Quick Actions</CardTitle>
						<CardDescription>Common tasks to get you started</CardDescription>
					</CardHeader>
					<CardContent>
						<div class="flex">
							<Button variant="outline" class="h-20 flex-1 flex-col gap-2">
								<!-- Replaced Plus icon with Iconify -->
								<Icon icon="lucide:plus" class="h-6 w-6" />
								Create Form
							</Button>
						</div>
					</CardContent>
				</Card>

				<!-- stats form -->
				<div class="flex">
					<!-- Recent Forms -->
					<div class="flex-1">
						<Card>
							<CardHeader>
								<div class="flex items-center justify-between">
									<div>
										<CardTitle>Recent Forms</CardTitle>
										<CardDescription>Your latest form activities</CardDescription>
									</div>
									<Button variant="ghost" size="sm">
										View All
										<!-- Replaced ChevronRight icon with Iconify -->
										<Icon icon="lucide:chevron-right" class="ml-1 h-4 w-4" />
									</Button>
								</div>
							</CardHeader>
							<CardContent>
								<div class="space-y-4">
									{#each recentForms as form}
										<div
											class="border-border hover:bg-accent/50 flex items-center justify-between rounded-lg border p-4 transition-colors"
										>
											<div class="flex items-center gap-3">
												<div class="bg-muted rounded-md p-2">
													<!-- Replaced FileText icon with Iconify -->
													<Icon icon="lucide:file-text" class="text-muted-foreground h-4 w-4" />
												</div>
												<div>
													<h4 class="text-foreground font-medium">{form.title}</h4>
													<p class="text-muted-foreground text-sm">
														{form.responses} responses • {form.lastUpdated}
													</p>
												</div>
											</div>
											<div class="flex items-center gap-2">
												<Badge
													variant={form.status === 'active'
														? 'default'
														: form.status === 'draft'
															? 'secondary'
															: 'outline'}
												>
													{form.status}
												</Badge>
												<Button variant="ghost" size="sm">
													<!-- Replaced ChevronRight icon with Iconify -->
													<Icon icon="lucide:chevron-right" class="h-4 w-4" />
												</Button>
											</div>
										</div>
									{/each}
								</div>
							</CardContent>
						</Card>
					</div>
				</div>
			</main>
		</div>
	</div>
{/if}
