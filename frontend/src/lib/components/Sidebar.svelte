<script lang="ts">
	import { Button } from '$lib/components/ui/button';
	import Icon from '@iconify/svelte';
</script>

<!-- Sidebar -->
<aside class="border-border bg-card w-64 border-r">
	<nav class="space-y-2 p-4">
		<div class="mb-6">
			<Button class="w-full justify-start gap-2" variant="default">
				<!-- Replaced Plus icon with Iconify -->
				<Icon icon="lucide:plus" class="h-4 w-4" />
				Create New Form
			</Button>
		</div>

		<div class="space-y-1">
			<h3 class="text-muted-foreground mb-2 px-2 text-xs font-medium uppercase tracking-wider">
				formulir yang kamu upload
			</h3>
			<a
				href="/dashboard"
				class="bg-accent text-accent-foreground flex items-center gap-2 rounded-md px-2 py-2 text-sm font-medium"
			>
				<Icon icon="fluent:form-20-regular" class="h-4 w-4" />
				Inovasi karya masa depan
			</a>
			<Button variant="ghost" size="sm">
				View All
				<Icon icon="lucide:chevron-right" class="ml-1 h-4 w-4" />
			</Button>
		</div>
	</nav>
</aside>
