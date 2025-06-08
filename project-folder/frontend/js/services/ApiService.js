class ApiService {
  static async authFetch(url, options = {}) {
    const token = localStorage.getItem("jwt_token")
    if (!token) {
      window.location.href = "#home"
      throw new Error("No token found")
    }

    const headers = {
      "Content-Type": "application/json",
      Authorization: "Bearer " + token,
      ...options.headers
    }

    try {
      const response = await fetch(url, {
        ...options,
        headers
      })

      if (response.status === 401) {
        localStorage.removeItem("jwt_token")
        localStorage.removeItem("user")
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
      const url = endpoint ? `/AmerBidzevic/Web-Project/project-folder/backend/products/${endpoint}` : `/AmerBidzevic/Web-Project/project-folder/backend/products`
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
      const response = await fetch(`/AmerBidzevic/Web-Project/project-folder/backend/products/${id}`)
      if (!response.ok) throw new Error("Failed to fetch product")
      return await response.json()
    } catch (error) {
      console.error(`Error loading product ${id}:`, error)
      throw error
    }
  }
}

export default ApiService
