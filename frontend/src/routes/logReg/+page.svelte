<script lang="ts">
	// SHADCN IMPORTS
	import { toast } from './../../../node_modules/svelte-sonner/dist/toast-state.svelte.js';

	// iconify
	import Icon from './../../../node_modules/@iconify/svelte/dist/Icon.svelte';

	// TYPES
	interface dataUserTypes {
		nama: string;
		email: string;
		password: string;
		confirmPassword: string;
	}

	// HOOKS
	let isLogin = $state<boolean>(true);
	let dataUser = $state<dataUserTypes>({
		nama: '',
		email: '',
		password: '',
		confirmPassword: ''
	});
	let isPolicyChecked = $state<boolean>(false);

	// FUNCTIONS
	const apakahInputHanyaBerupaHuruf = (txt: string): boolean => {
		return /^[a-zA-Z]+$/.test(txt);
	};

	const cekFormatEmail = (email: string): boolean | null => {
		// cek format email
		const cekFormat = /^[a-zA-Z0-9@._]+$/.test(email);
		if (cekFormat) return null;

		// cek  domain  email
		const cekDomain = email.split('@')[1];
		if (cekDomain !== 'gmail.com') return null;

		return true;
	};

	const inputChecks = (): boolean | null => {
		if (dataUser == null) return null;
		if (Object.keys(dataUser).length === 0) return null;
		if (!apakahInputHanyaBerupaHuruf) return null;
		if (cekFormatEmail == null) return null;
		if (!isLogin) {
			if (dataUser.confirmPassword !== dataUser.password) return null;
		}
		return true;
	};

	// HANLDERS
	const handleLogin = (e: Event) => {
		e.preventDefault();
		if (inputChecks == null) {
			const pesan = 'Maaf seperti nya ada yang salah nih sama input kamu';
			toast.error(pesan, {
				description: 'Coba cek ulang dehh...'
			});
		}
	};
</script>

<div class="flex min-h-screen items-center justify-center bg-gray-50 p-4">
	<div class="w-full max-w-md">
		<!-- Header -->
		<div class="mb-8 text-center">
			<h1 class="mb-2 text-2xl font-bold text-gray-900">
				{isLogin ? 'Masuk ke InnovaHub' : 'Buat Akun Baru di InnovaHub'}
			</h1>
			<p class="text-gray-600">
				{isLogin ? 'Silakan masuk dengan akun Anda' : 'Daftar untuk membuat akun baru'}
			</p>
		</div>

		<!-- Form Container -->
		<div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
			<!-- Toggle Buttons -->
			<div class="mb-6 flex rounded-lg bg-gray-100 p-1">
				<button
					onclick={() => (isLogin = true)}
					class="flex-1 rounded-md px-4 py-2 text-sm font-medium transition-all duration-200 {isLogin
						? 'bg-white text-gray-900 shadow-sm'
						: 'text-gray-600 hover:text-gray-900'}"
				>
					Masuk
				</button>
				<button
					onclick={() => (isLogin = false)}
					class="flex-1 rounded-md px-4 py-2 text-sm font-medium transition-all duration-200 {!isLogin
						? 'bg-white text-gray-900 shadow-sm'
						: 'text-gray-600 hover:text-gray-900'}"
				>
					Daftar
				</button>
			</div>

			<!-- Form -->
			<form class="space-y-4" onsubmit={(e) => handleLogin(e)}>
				<!-- Name Field (Only for Register) -->
				{#if !isLogin}
					<div>
						<label for="name" class="mb-1 block text-sm font-medium text-gray-700">
							Nama Lengkap
						</label>
						<input
							bind:value={dataUser.nama}
							type="text"
							id="name"
							class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-gray-500"
							placeholder="Masukkan nama lengkap"
						/>
					</div>
				{/if}

				<!-- Email Field -->
				<div>
					<label for="email" class="mb-1 block text-sm font-medium text-gray-700"> Email </label>
					<input
						bind:value={dataUser.email}
						type="email"
						id="email"
						class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-gray-500"
						placeholder="Masukkan email"
					/>
				</div>

				<!-- Password Field -->
				<div>
					<label for="password" class="mb-1 block text-sm font-medium text-gray-700">
						Password
					</label>
					<input
						bind:value={dataUser.password}
						type="password"
						id="password"
						class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-gray-500"
						placeholder="Masukkan password"
					/>
				</div>

				<!-- Confirm Password Field (Only for Register) -->
				{#if !isLogin}
					<div>
						<label for="confirmPassword" class="mb-1 block text-sm font-medium text-gray-700">
							Konfirmasi Password
						</label>
						<input
							bind:value={dataUser.confirmPassword}
							type="password"
							id="confirmPassword"
							class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-gray-500"
							placeholder="Konfirmasi password"
						/>
					</div>
				{/if}

				<!-- Remember Me / Terms (Conditional) -->
				<div class="flex items-center justify-between">
					{#if isLogin}
						<label class="flex items-center">
							<input
								type="checkbox"
								class="rounded border-gray-300 text-gray-600 focus:ring-gray-500"
							/>
							<span class="ml-2 text-sm text-gray-600">Ingat saya</span>
						</label>
						<button onclick={() => {}} class="text-sm text-gray-600 underline hover:text-gray-900">
							Lupa password?
						</button>
					{:else}
						<label class="flex items-start">
							<input
								type="checkbox"
								class="mt-1 rounded border-gray-300 text-gray-600 focus:ring-gray-500"
							/>
							<span class="ml-2 text-sm text-gray-600">
								Saya setuju dengan <a
									href="https://example.com/terms"
									class="underline hover:text-gray-900">syarat dan ketentuan</a
								>
							</span>
						</label>
					{/if}
				</div>

				<!-- Submit Button -->
				<button
					type="submit"
					class="w-full rounded-md bg-gray-900 px-4 py-2 font-medium text-white transition-colors duration-200 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
				>
					{isLogin ? 'Masuk' : 'Daftar'}
				</button>
			</form>

			<!-- Footer Text -->
			<div class="mt-6 text-center">
				<p class="text-sm text-gray-600">
					{isLogin ? 'Belum punya akun?' : 'Sudah punya akun?'}
					<button
						onclick={() => (isLogin = !isLogin)}
						class="ml-1 font-medium text-gray-900 hover:underline"
					>
						{isLogin ? 'Daftar sekarang' : 'Masuk di sini'}
					</button>
				</p>
			</div>
		</div>
	</div>
</div>
