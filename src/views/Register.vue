<template>
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 400px; border-radius: 15px;">
      <h3 class="text-center mb-4">สมัครสมาชิก</h3>

      <form @submit.prevent="handleRegister">
        
        <div class="mb-3">
          <label class="form-label">ชื่อ</label>
          <input 
            type="text" 
            class="form-control" 
            v-model="firstname"
            placeholder="กรอกชื่อ"
            required
          >
        </div>

        <div class="mb-3">
          <label class="form-label">นามสกุล</label>
          <input 
            type="text" 
            class="form-control" 
            v-model="lastname"
            placeholder="กรอกนามสกุล"
            required
          >
        </div>

        <div class="mb-3">
          <label class="form-label">เบอร์โทร</label>
          <input 
            type="tel" 
            class="form-control" 
            v-model="phone"
            placeholder="กรอกเบอร์โทร"
            required
          >
        </div>

        <div class="mb-3">
          <label class="form-label">Username</label>
          <input 
            type="text" 
            class="form-control" 
            v-model="username"
            placeholder="Enter username"
            required
          >
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input 
            type="password" 
            class="form-control" 
            v-model="password"
            placeholder="Enter password"
            required
          >
        </div>

        <div class="mb-3">
          <label class="form-label">ยืนยัน Password</label>
          <input 
            type="password" 
            class="form-control" 
            v-model="confirmPassword"
            placeholder="ยืนยันรหัสผ่าน"
            required
          >
        </div>

        <button type="submit" class="btn btn-success w-100" :disabled="loading">
          {{ loading ? 'กำลังสมัคร...' : 'สมัครสมาชิก' }}
        </button>

        <div class="text-center mt-3">
          <small>มีบัญชีอยู่แล้ว? <router-link to="/login">เข้าสู่ระบบ</router-link></small>
        </div>

      </form>

      <div v-if="message" :class="['alert', messageType === 'success' ? 'alert-success' : 'alert-danger', 'mt-3']" role="alert">
        {{ message }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      firstname: '',
      lastname: '',
      phone: '',
      username: '',
      password: '',
      confirmPassword: '',
      loading: false,
      message: '',
      messageType: ''
    }
  },
  methods: {
    async handleRegister() {
      // Validate all fields
      if (
        !this.firstname ||
        !this.lastname ||
        !this.phone ||
        !this.username ||
        !this.password ||
        !this.confirmPassword
      ) {
        this.showMessage('กรุณากรอกข้อมูลให้ครบ', 'error')
        return
      }

      // Validate password match
      if (this.password !== this.confirmPassword) {
        this.showMessage('รหัสผ่านไม่ตรงกัน', 'error')
        return
      }

      // Validate password length
      if (this.password.length < 6) {
        this.showMessage('รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร', 'error')
        return
      }

      // Validate phone number
      if (!/^\d{10}$/.test(this.phone)) {
        this.showMessage('เบอร์โทรต้องเป็นตัวเลข 10 หลัก', 'error')
        return
      }

      this.loading = true

      try {
        const response = await fetch('http://localhost/project-vue-68703256/php_api/add_customer.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            firstName: this.firstname,
            lastName: this.lastname,
            phone: this.phone,
            username: this.username,
            password: this.password
          })
        })

        // ตรวจสอบ HTTP status
        if (!response.ok) {
          const errorData = await response.json()
          this.showMessage(errorData.message || `ข้อผิดพลาด HTTP ${response.status}`, 'error')
          console.error('HTTP Error:', response.status, errorData)
          return
        }

        const result = await response.json()
        console.log('Response:', result)

        if (result.status === 'success') {
          this.showMessage('สมัครสมาชิกสำเร็จ! กำลังเปลี่ยนหน้า..', 'success')
          
          // Clear form
          setTimeout(() => {
            this.firstname = ''
            this.lastname = ''
            this.phone = ''
            this.username = ''
            this.password = ''
            this.confirmPassword = ''
            // Redirect to home or login
            this.$router.push('/')
          }, 1500)
        } else {
          this.showMessage(result.message || 'ข้อผิดพลาดที่ไม่ทราบ', 'error')
        }
      } catch (error) {
        console.error('Error:', error)
        this.showMessage('ข้อผิดพลาดในการเชื่อมต่อ: ' + error.message, 'error')
      } finally {
        this.loading = false
      }
    },

    showMessage(msg, type) {
      this.message = msg
      this.messageType = type
      
      // Auto-clear error messages after 4 seconds
      if (type === 'error') {
        setTimeout(() => {
          this.message = ''
        }, 4000)
      }
    }
  }
}
</script>

<style scoped>
.card {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border: none;
}

.form-control:focus {
  border-color: #28a745;
  box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

small a {
  color: #28a745;
  text-decoration: none;
}

small a:hover {
  text-decoration: underline;
}

.alert {
  border-radius: 5px;
  font-size: 0.9rem;
}
</style>