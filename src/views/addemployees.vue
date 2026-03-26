<template>
  <div class="container my-5">
    <div class="d-flex justify-content-center align-items-center vh-100">
      <div class="card shadow p-4" style="width: 400px; border-radius: 15px;">
        
        <h3 class="text-center mb-4">เพิ่มชื้อพนักงาน</h3>

        <form @submit.prevent="addCustomer">

          <div class="mb-3">
            <label class="form-label">ชื่อ</label>
            <input type="text" class="form-control"
              v-model="form.firstName" placeholder="ชื่อ" required>
          </div>

          <div class="mb-3">
            <label class="form-label">นามสกุล</label>
            <input type="text" class="form-control"
              v-model="form.lastName" placeholder="นามสกุล" required>
          </div>

          <div class="mb-3">
            <label class="form-label">เบอร์โทรศัพท์</label>
            <input type="text" class="form-control"
              v-model="form.phone" placeholder="เบอร์โทรศัพท์" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">
            บันทึก
          </button>

        </form>

        <!-- แสดงผล -->
        <div v-if="message" class="alert mt-3"
             :class="status === 'success' ? 'alert-success' : 'alert-danger'">
          {{ message }}
        </div>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        firstName: '',
        lastName: '',
        phone: '',
        username: '',
        password: ''
      },
      message: '',
      status: ''
    }
  },
  methods: {
    async addCustomer() {
      try {
        const res = await fetch('http://localhost/project-vue-41970137-api/php_api/add_customer.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.form)
        });

        const result = await res.json();

        this.message = result.message;
        this.status = result.status;

        // เคลียร์ฟอร์ม
        if (result.status === 'success') {
          this.form = {
            firstName: '',
            lastName: '',
            phone: '',
            username: '',
            password: ''
          };
        }

      } catch (error) {
        this.message = 'เชื่อมต่อ API ไม่สำเร็จ';
        this.status = 'error';
      }
    }
  }
}
</script>