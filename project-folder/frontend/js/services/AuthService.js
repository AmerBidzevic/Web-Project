class AuthService {
  static API_BASE_URL = "http://localhost/AmerBidzevic/Web-Project/project-folder/backend/auth"

  static async _handleResponse(response) {
    const text = await response.text()

    if (!response.ok) {
      if (response.headers.get("content-type")?.includes("application/json")) {
        const errorData = JSON.parse(text)
        throw new Error(errorData.error || "Request failed")
      }
      throw new Error("Request failed. Please check your connection and try again.")
    }

    return JSON.parse(text)
  }

  static async login(email, password) {
    const response = await fetch(`${this.API_BASE_URL}/login`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ email, password })
    })

    return this._handleResponse(response)
  }

  static async register(username, email, password) {
    const response = await fetch(`${this.API_BASE_URL}/register`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ username, email, password })
    })

    return this._handleResponse(response)
  }

  static logout() {
    localStorage.removeItem("jwt_token")
    localStorage.removeItem("user")
    window.location.href = "#home"
  }
}
export default AuthService
