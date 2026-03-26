<template>
    <div class="container my-5">
        <h2>แสดงข้อมูลพนักงาน</h2>
        
        <div v-if="loading" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">กำลังโหลด...</span>
            </div>
            <p>กำลังโหลดข้อมูล...</p>
        </div>
        
        <div v-else-if="error" class="alert alert-danger">
            <strong>ข้อผิดพลาด:</strong> {{ error }}
        </div>
        
        <div v-else-if="employees.length === 0" class="alert alert-info">
            ไม่พบข้อมูลพนักงาน
        </div>
        
        <table v-else class="table table-hover">
            <thead>
                <tr class="table-dark">
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
                    <td>{{ item.full_name }}</td>
                    <td>{{ item.department }}</td>
                    <td>{{ item.salary }}</td>
                    <td>{{ item.created_at }}</td>
                    <td>
                        <span v-if="item.active==1" class="badge bg-success">ปกติ</span>
                        <span v-else class="badge bg-danger">ลาออก</span>
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
    
    if (!res.ok) {
      throw new Error(`HTTP error! status: ${res.status}`)
    }
    
    const data = await res.json()
    
    // Check if the response contains an error
    if (data.error) {
      throw new Error(data.error)
    }
    
    employees.value = data
  } catch (err) {
    console.error('Error loading employees:', err)
    error.value = err.message || 'โหลดข้อมูลไม่สำเร็จ'
  } finally {
    loading.value = false
  }
})
</script>