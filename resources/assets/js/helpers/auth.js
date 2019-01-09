export function login (credentials) {
    return new Promise ((resolve,reject) =>{
        axops.post('/api/auth/login', credentials).then((response)=>{
            resolve(response.data);
        }).catch((err)=>{
            reject("Wrong email or password");
        });
    });
}