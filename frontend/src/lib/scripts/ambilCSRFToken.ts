import api from "$lib/axiosConfig";

export function ambilCSRFTokenDariLaravel(): Promise<boolean> {
    return new Promise((resolve, reject) => {
        api.get('/sanctum/csrf-cookie')
            .then(() => {
                resolve(true);
            })
            .catch((error) => {
                reject(error);
            });
    })  
}