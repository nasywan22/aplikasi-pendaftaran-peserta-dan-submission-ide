<script lang="ts">
	// SHADCN IMPORTS
	import { toast } from 'svelte-sonner';
	import { Button } from '$lib/components/ui/button/index.js';

	// icons
	import Icon from '@iconify/svelte';

	// axios
	import api from '$lib/axiosConfig';
	import { type AxiosResponse } from 'axios';

	// svelte tools
	import { onMount } from 'svelte';
	import { goto } from '$app/navigation';

	// import milik sendiri
	import Captcha from '$lib/components/Captcha.svelte';

	// TYPES
	interface dataUserTypes {
		name?: string;
		email: string;
		telepon?: string;
		password: string;
		'g-recaptcha-response': string;
		confirmPassword?: string;
	}

	// HOOKS
	let dataUser = $state<dataUserTypes>({
		email: '',
		password: '',
		'g-recaptcha-response': ''
	});

	// trackers hooks
	let isLogin = $state<boolean>(true);
	let isPolicyChecked = $state<boolean>(false);
	let sedangMengirimKeServer = $state<boolean>(false);
	let apakahBerhasilLogin = $state<boolean>(false);
	let PageTerakhir = $state<string>('');

	// HOOKS HANDLERS
	onMount(() => {
		PageTerakhir = ambilPageTujuanTerakhirDiParameter();
	});

	$effect(() => {
		ambilCSRFCookie();
		if (sedangMengirimKeServer && !isLogin) {
			AksiAutentikasi('register');
		} else if (sedangMengirimKeServer && isLogin) {
			AksiAutentikasi('login');
		}
	});

	// FUNCTIONS
	async function ambilCSRFCookie() {
		try {
			await api.get('/sanctum/csrf-cookie');
		} catch (error) {
			console.error(error);
		}
	}

	function ambilPageTujuanTerakhirDiParameter() {
		const seluruhData: string = window.location.search;
		const parameter: URLSearchParams = new URLSearchParams(seluruhData);
		const pageTerakhir: string | null = parameter.get('lastPage');
		return pageTerakhir == null ? '' : pageTerakhir;
	}

	function ambilCookie(cookieName: string) {
		const value = `; ${document.cookie}`;
		const parts = value.split(`; ${cookieName}=`);

		if (parts.length === 2) {
			const last = parts.pop();
			if (last) {
				return decodeURIComponent(last.split(';').shift()!);
			}
		}
		return undefined;
	}

	async function AksiAutentikasi(jenisAutentikasi: string) {
		try {
			const response: AxiosResponse<any, any, {}> = await api.post(
				`/${jenisAutentikasi}`,
				dataUser
			);

			// data response
			const data = await response.data;
			const { message } = data;

			// set tracker keberhasilan login
			if (isLogin) apakahBerhasilLogin = true;
			isLogin = true;

			// notifikasi
			const pesan = isLogin ? message : 'Akun mu berhasil dibuat nih :D';
			const deskripsi = isLogin ? 'Selamat datang di InnovaHub' : 'Silahkan masuk sekarang';
			notifSuccess(pesan, deskripsi);

			// reset semua input
			resetSemuaInput();

			// kembali ke halaman tujuan sebelumnya
			if (apakahBerhasilLogin) goto(`/${PageTerakhir}`);
		} catch (error) {
			// notifikasi error
			const pesanErr = 'Waduh ada yang salah nih di sistem kitanya :(';
			const deskripsiErr = 'Silahkan coba lagi yaa...';
			notifError(pesanErr, deskripsiErr);

			// print error di console browser
			console.error(error);
		} finally {
			// menghapus status pengiriman ke server
			sedangMengirimKeServer = false;

			// reset captcha
			window.grecaptcha.reset();
		}
	}

	function resetSemuaInput() {
		dataUser = {
			email: '',
			password: '',
			'g-recaptcha-response': ''
		};
	}

	function notifSuccess(pesan: string, deskripsi: string) {
		toast.success(pesan, {
			description: deskripsi,
			duration: 5000,
			position: 'top-center'
		});
	}

	function notifError(pesan: string, deskripsi: string) {
		toast.error(pesan, {
			description: deskripsi,
			duration: 5000,
			position: 'top-center'
		});
	}

	const apakahInputNamaHanyaBerupaHuruf = (nama: string): boolean => {
		return /^[a-zA-Z]+$/.test(nama);
	};

	const cekFormatEmail = (): boolean => {
		const email = dataUser.email;

		// cek format email
		const cekFormat = /^[a-zA-Z0-9@._]+$/.test(email);
		if (cekFormat) return false;

		// cek domain email
		const cekDomain = email.split('@')[1];
		if (cekDomain !== 'gmail.com') return false;

		return true;
	};

	const inputChecks = (): boolean => {
		const apakahUserPunyaData: boolean = Object.keys(dataUser).length !== 0;
		const apakahPasswordSama = dataUser.password === dataUser.confirmPassword;

		if (!apakahUserPunyaData) return false;
		if (dataUser.name && !apakahInputNamaHanyaBerupaHuruf(dataUser.name)) return false;
		if (!cekFormatEmail) return false;

		if (!isLogin) {
			if (!apakahPasswordSama) return false;
		}

		return true;
	};

	// HANLDERS
	const handleLogin = (e: Event) => {
		e.preventDefault();
		if (!inputChecks) {
			const pesan: string = 'Maaf seperti nya ada yang salah nih sama input kamu';
			const deskripsi: string = 'Coba cek ulang dehh...';
			notifError(pesan, deskripsi);
		}
		sedangMengirimKeServer = true;
	};

	const tanganiTangkapTokenCaptcha = (token: string) => {
		dataUser['g-recaptcha-response'] = token;	
	};
</script>

<div class="flex min-h-screen items-center justify-center bg-gray-50 p-4">
	<div class="w-full max-w-4xl">
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
		<div class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm">
			<!-- Toggle Buttons -->
			<div class="mb-8 flex justify-center">
				<div class="flex w-80 rounded-lg bg-gray-100 p-1">
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
			</div>

			<!-- Form -->
			<form class="space-y-6" onsubmit={handleLogin}>
				{#if isLogin}
					<!-- Login Form - Vertical Layout -->
					<div class="space-y-6">
						<!-- Email Field -->
						<div>
							<label for="email" class="mb-1 block text-sm font-medium text-gray-700">
								Email
							</label>
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
					</div>

					<!-- Remember Me / Forgot Password -->
					<div class="flex items-center justify-between">
						<label class="flex items-center">
							<input
								type="checkbox"
								class="rounded border-gray-300 text-gray-600 focus:ring-gray-500"
							/>
							<span class="ml-2 text-sm text-gray-600">Ingat saya</span>
						</label>
						<button
							type="button"
							onclick={() => {}}
							class="text-sm text-gray-600 underline hover:text-gray-900"
						>
							Lupa password?
						</button>
					</div>
				{:else}
					<!-- Register Form - 2 Column Layout -->
					<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
						<!-- Name Field -->
						<div>
							<label for="name" class="mb-1 block text-sm font-medium text-gray-700">
								Nama Lengkap
							</label>
							<input
								bind:value={dataUser.name}
								type="text"
								id="name"
								class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-gray-500"
								placeholder="Masukkan nama lengkap"
							/>
						</div>

						<!-- Email Field -->
						<div>
							<label for="email" class="mb-1 block text-sm font-medium text-gray-700">
								Email
							</label>
							<input
								bind:value={dataUser.email}
								type="email"
								id="email"
								class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-gray-500"
								placeholder="Masukkan email"
							/>
						</div>

						<!-- Phone Field -->
						<div>
							<label for="telepon" class="mb-1 block text-sm font-medium text-gray-700">
								Nomor Telepon
							</label>
							<input
								bind:value={dataUser.telepon}
								type="tel"
								id="telepon"
								class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-gray-500"
								placeholder="Masukan nomor telepon"
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

						<!-- Confirm Password Field - Full Width -->
						<div class="md:col-span-2">
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
					</div>

					<!-- Terms Agreement -->
					<div class="flex items-start justify-center">
						<label class="flex items-start">
							<input
								bind:checked={isPolicyChecked}
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
					</div>
				{/if}

				<div class="flex justify-center">
					<Captcha tangkapToken={tanganiTangkapTokenCaptcha}></Captcha>
				</div>

				<!-- Submit Button -->
				<div class="flex justify-center">
					<button
						disabled={!isPolicyChecked && !isLogin}
						type="submit"
						class="w-full max-w-xs rounded-md bg-gray-900 px-8 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-800 disabled:cursor-not-allowed disabled:bg-gray-300"
					>
						{#if sedangMengirimKeServer}
							<span class="flex animate-spin items-center justify-center">
								<Icon icon="picon:spinner" width="16" height="16" />
							</span>
						{:else}
							{isLogin ? 'Masuk' : 'Daftar'}
						{/if}
					</button>
				</div>
			</form>

			<!-- Footer Text -->
			<div class="mt-8 text-center">
				<p class="text-sm text-gray-600">
					{isLogin ? 'Belum punya akun?' : 'Sudah punya akun?'}
					<button
						type="button"
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
