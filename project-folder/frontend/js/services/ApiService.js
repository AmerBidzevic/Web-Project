class ApiService {
  static API_BASE_URL = "http://localhost/AmerBidzevic/Web-Project/project-folder/backend"

  static async authFetch(endpoint, options = {}) {
    const token = localStorage.getItem("jwt_token")
    console.log("Sending token:", token)
    if (!token) {
      window.location.href = "#home"
      throw new Error("No token found")
    }

    const headers = {
      ...options.headers,
      "Content-Type": "application/json",
      Authorization: "Bearer " + token
    }

    const url = endpoint.startsWith("http") ? endpoint : this.API_BASE_URL + (endpoint.startsWith("/") ? endpoint : "/" + endpoint)

    try {
      const response = await fetch(url, {
        ...options,
        headers
      })

      if (response.status === 401) {
        window.location.href = "#home"
        throw new Error("Unauthorized")
      }

      return response
    } catch (error) {
      console.error("Request failed:", error)
      throw error
    }
  }

  static async fetchProducts(endpoint = "") {
    try {
      const url = this.API_BASE_URL + "/products" + (endpoint ? `/${endpoint}` : "")
      const response = await fetch(url)
      if (!response.ok) throw new Error("Failed to fetch products")
      return await response.json()
    } catch (error) {
      console.error(`Error loading ${endpoint || "all"} products:`, error)
      throw error
    }
  }

  static async fetchProduct(id) {
    try {
      const response = await fetch(this.API_BASE_URL + `/products/${id}`)
      if (!response.ok) throw new Error("Failed to fetch product")
      return await response.json()
    } catch (error) {
      console.error(`Error loading product ${id}:`, error)
      throw error
    }
  }
}

export default ApiService
