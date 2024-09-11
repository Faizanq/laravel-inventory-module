import axios from 'axios'

// Create an axios instance
const axiosServices = axios.create({
  baseURL: 'http://127.0.0.1:8000', // Ensure you are using the correct base URL
  withCredentials: false, // Set to false since we're using token-based auth
})

// Request interceptor to add the Authorization token
axiosServices.interceptors.request.use(
  config => {
    // Show loader by setting a flag in localStorage
    localStorage.setItem('loading', 'true')

    // Get token from localStorage and set Authorization header
    const token = localStorage.getItem('auth_token')
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`
    }

    return config
  },
  error => {
    // Hide loader if there's an error
    localStorage.removeItem('loading')
    return Promise.reject(error)
  },
)

// Response interceptor to hide the loader and handle errors
axiosServices.interceptors.response.use(
  response => {
    // Hide loader when a response is received
    localStorage.removeItem('loading')

    // Optionally handle token refresh if returned in response
    if (response.headers['new-token']) {
      const newToken = response.headers['new-token']
      localStorage.setItem('auth_token', newToken)
      axiosServices.defaults.headers.common['Authorization'] = `Bearer ${newToken}`
    }

    return response.data
  },
  error => {
    // Hide loader if there's an error
    localStorage.removeItem('loading')

    // Optionally handle token expiration or invalid token cases
    if (error.response && error.response.status === 401) {
      // Token has expired or is invalid, handle accordingly
      localStorage.removeItem('auth_token')
      // Redirect to login page or notify the user
    }

    return Promise.reject(error?.response?.data || errpr)
  },
)

export default axiosServices
