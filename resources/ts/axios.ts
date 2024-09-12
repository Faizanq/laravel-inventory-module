import axios from 'axios'
import toastr from 'toastr'
import 'toastr/build/toastr.min.css'

toastr.options = {
  closeButton: true,
  debug: false,
  newestOnTop: true,
  progressBar: true,
  positionClass: 'toast-top-right',
  preventDuplicates: false,
  onclick: null,
  showDuration: '200',
  hideDuration: '300',
  timeOut: '3000',
  extendedTimeOut: '500',
  showEasing: 'swing',
  hideEasing: 'linear',
  showMethod: 'fadeIn',
  hideMethod: 'fadeOut',
}

// Create an axios instance
const axiosServices = axios.create({
  baseURL: process.env.APP_URL || 'http://127.0.0.1:8000', // Ensure you are using the correct base URL
  withCredentials: false, // Set to false since we're using token-based auth
})

// Request interceptor to add the Authorization token
axiosServices.interceptors.request.use(
  config => {
    // Show loader (Consider using state management instead of localStorage)
    // localStorage.setItem('loading', 'true') // If using state management, update state here

    // Get token from localStorage and set Authorization header
    const token = localStorage.getItem('auth_token')
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`
    }
    const xsrfToken = getCookie('XSRF-TOKEN')
    if (xsrfToken) {
      config.headers['X-XSRF-TOKEN'] = xsrfToken
    }
    return config
  },
  error => {
    // Hide loader if there's an error (Consider using state management instead of localStorage)
    // localStorage.removeItem('loading') // If using state management, update state here
    return Promise.reject(error)
  },
)

function getCookie(name: string) {
  const value = `; ${document.cookie}`
  const parts = value.split(`; ${name}=`)
  if (parts.length === 2) return parts.pop().split(';').shift()
}

// Response interceptor to hide the loader and handle errors
axiosServices.interceptors.response.use(
  response => {
    // Hide loader when a response is received (Consider using state management instead of localStorage)
    // localStorage.removeItem('loading') // If using state management, update state here

    // Optionally handle token refresh if returned in response
    const newToken = response.headers['new-token']
    if (newToken) {
      localStorage.setItem('auth_token', newToken)
      axiosServices.defaults.headers.common['Authorization'] = `Bearer ${newToken}`
    }
    if (response.data?.success && response.data?.message) {
      const message = response.data?.message
      toastr.success(message, 'Success')
    }

    return response.data
  },
  error => {
    // Hide loader if there's an error (Consider using state management instead of localStorage)
    // localStorage.removeItem('loading') // If using state management, update state here

    // Optionally handle token expiration or invalid token cases
    if (error.response && error.response.status === 401) {
      // Token has expired or is invalid, handle accordingly
      localStorage.removeItem('auth_token')
      // Redirect to login page or notify the user
    }

    const message = error?.response?.data?.message || 'Internal Server Error!'
    toastr.error(message, 'Error')

    return Promise.reject(error?.response?.data || error)
  },
)

export default axiosServices
