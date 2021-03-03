import Axios from 'axios';
import API_URL from '@/services/api';

const authenticationService = {
    login: (data) => {
        return Axios.post(API_URL.login, data);
    },
    logout: () => {
        return Axios.post(API_URL.logout);
    },
};

export default authenticationService;