<template>
    <div class="container my-5">
        <h2>แสดงข้อมูลพนักงาน</h2>
        <table class="table tadle-hover">
  <thead>
    <tr class="table table-dark table-hover">
      <th>รหัสพนักงาน</th>
      <th>ชื่อ</th>
      <th>ตำแหน่ง</th>
      <th>เงินเดือน</th>
      <th>สร้างเมื่อ</th>
      <th>สถานะ</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="item in employees" :key="item.emp_id">
      <td>{{ item.emp_id }}</td>
      <td>{{ item.full_Name }}</td>
      <td>{{ item.department }}</td>
      <td>{{ item.salary }}</td>
      <td>{{ item.created_at }}</td>
      <td>
        <span v-if="item.active==1">ปกติ</span>
        <span v-else>ลาออก</span>
      </td>
    </tr>
  </tbody>
</table>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const employees = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    const res = await fetch('http://localhost/project-vue-68703256/php_api/show_Employees.php')
    employees.value = await res.json()
    //products.value = data.products
  } catch (err) {
    error.value = 'โหลดข้อมูลไม่สำเร็จ'
  } finally {
    loading.value = false
  }
})
</script>