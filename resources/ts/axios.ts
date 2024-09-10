import axios from 'axios'

// Create an Axios instance
const axiosServices = axios.create({
  baseURL: 'http://127.0.0.1:8000', // Replace with your API base URL
  withCredentials: true, // If you need to send cookies with requests
})

// Response Interceptor
axiosServices.interceptors.response.use(
  response => {
    // Check if the "New-Token" header is present in the response
    if (response.headers && response.headers['new-token']) {
      // Get the new token value from the response header
      const newToken = response.headers['new-token']

      // Store the new token in localStorage
      localStorage.setItem('auth_token', newToken)

      // Update the Axios default headers for authorization
      axiosServices.defaults.headers.common['Authorization'] = `Bearer ${newToken}`
    }

    // Return the response for further processing
    return response.data
  },
  error => {
    // Handle errors by using a custom error handler or default error response
    return Promise.reject(error.response?.data || error)
  },
)

export default axiosServices
