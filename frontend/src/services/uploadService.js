import Axios from 'axios';
import API_URL from '@/services/api';

const uploadService = {
    fetch: (userId) => {
        return Axios.get(`${API_URL.fetch}/${userId}`);
    },
    information: (userId) => {
        return Axios.get(`${API_URL.information}/${userId}`);
    },
    upload: (data) => {
        return Axios.post(API_URL.upload, data);
    },
    delete: (imageId) => {
        return Axios.delete(`${API_URL.delete}/${imageId}`);
    },
};

export default uploadService;