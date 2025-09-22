import api from "$lib/axiosConfig";
import type { AxiosResponse } from "axios";

interface User {
    nama: string;
    email: string;
}

export function cekAkunUser(): Promise<User> {
    return new Promise((resolve, reject) => {
        api.get("/cekAkun")
            .then((response: AxiosResponse<any, any, {}>) => {
                const data = response.data;
                const user: User = {
                    nama: data.nama,
                    email: data.email
                }

                resolve(user);
            })
            .catch((error) => {
                reject(error);
            });
    });
}