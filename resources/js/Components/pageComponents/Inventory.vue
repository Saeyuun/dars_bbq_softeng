<template>
  <div class="inventory-container">
    <SidebarEmployee />
    <div class="inventory-content">
      <h2 class="inventory-title">Inventory</h2>
      <div class="inventory-header">
        <div class="inventory-actions">
          <input
            type="text"
            placeholder="🔍 Search Item ID"
            class="search-input"
          />
          <button class="search-button">Search Item</button>
        </div>
        <div class="add-item-wrapper">
          <button class="add-button">Add Item</button>
        </div>
      </div>
      
    </div>
  </div>
</template>

<script>
import SidebarEmployee from './side-bar-employee.vue';

export default {
  name: "Inventory",
  components: {
    SidebarEmployee,
  },
};
</script>

<style scoped>

.inventory-container {
  display: flex;
  height: 100vh;
  overflow: hidden;
  
}

.inventory-content {
  flex: 1;
  padding: 30px;
  
  overflow-y: auto;
}

.inventory-title {
  font-size: 24px;
  font-weight: 600;
  color: #742424;
  margin-bottom: 20px;
  text-align: left;
}

.inventory-header {
  background-color: #ffffff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0px 4px 50px rgba(0, 0, 0, 0.08);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}

.inventory-actions {
  display: flex;
  gap: 10px;
  align-items: center;
  flex-wrap: wrap;
}

.search-input {
  padding: 10px 14px;
  border: 2px solid #e19797;
  border-radius: 8px;
  font-size: 14px;
  width: 200px;
  background-color: white;
  color: black;
}

.search-button {
  background-color: white;
  color: #a03d3d;
  border-radius: 8px;
  padding: 10px 16px;
  font-size: 14px;
  cursor: pointer;
  transition: 0.2s ease;
}

.search-button:hover {
  background-color: #fce1e1;
}

.add-item-wrapper {
  display: flex;
  align-items: center;
}

.add-button {
  background-color: #6ce26c;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 10px 16px;
  font-size: 14px;
  cursor: pointer;
  transition: 0.2s ease;
}

.add-button:hover {
  background-color: #53c653;
}

</style>
