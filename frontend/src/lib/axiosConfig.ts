import axios from 'axios';

// bikin instance axios
const api = axios.create({
  baseURL: 'http://localhost:8000',
  withCredentials: true,
});

// function kecil buat ambil cookie
function getCookie(name: string): string | undefined {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) {
    return decodeURIComponent(parts.pop()!.split(';').shift()!);
  }
}

// pasang interceptor sebelum request dikirim
api.interceptors.request.use((config) => {
  const token = getCookie('XSRF-TOKEN');
  if (token) {
    config.headers['X-XSRF-TOKEN'] = token;
  }
  return config;
});

export default api;
