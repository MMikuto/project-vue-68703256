<template>
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 400px; border-radius: 15px;">
      <h3 class="text-center mb-4">Register</h3>

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

        <button type="submit" class="btn btn-success w-100">
          สมัครสมาชิก
        </button>

      </form>
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
      password: ''
    }
  },
  methods: {
    handleRegister() {
      if (
        !this.firstname ||
        !this.lastname ||
        !this.phone ||
        !this.username ||
        !this.password
      ) {
        alert('กรุณากรอกข้อมูลให้ครบ')
        return
      }

      console.log({
        firstname: this.firstname,
        lastname: this.lastname,
        phone: this.phone,
        username: this.username,
        password: this.password
      })

      alert('สมัครสมาชิกสำเร็จ (demo)')
      
      // 👉 ตรงนี้ค่อยไปต่อ API PHP
    }
  }
}
</script>

<style>
</style>