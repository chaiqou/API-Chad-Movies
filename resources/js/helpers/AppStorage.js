class AppStorage {
    storeToken(token) {
        localStorage.setItem('token', token);
    }
    store(token) {
        this.storeToken(token);
    }
    clear() {
        localStorage.removeItem('token');
    }
    getToken(token){
        localStorage.getItem(token);
    }
}

export default AppStorage = new AppStorage();
