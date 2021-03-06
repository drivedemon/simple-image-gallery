const BASE_URL = 'http://localhost:8000'
const BASE_API_URL = `${BASE_URL}/api`

const API_URL = {
    baseUrl: `${BASE_URL}`,
    fetch: `${BASE_API_URL}/fetch`,
    information: `${BASE_API_URL}/information`,
    login: `${BASE_API_URL}/login`,
    register: `${BASE_API_URL}/register`,
    upload: `${BASE_API_URL}/upload`,
}

export default API_URL;