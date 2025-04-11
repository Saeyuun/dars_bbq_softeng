<template>
  <header class="header-container">
    <h1 class="header-title">Inventory</h1>
    <div class="header-actions">
      <input
        type="text"
        placeholder="🔍 Search Item ID"
        class="search-input"
      />
      <button class="search-button">Search Item</button>
      <button class="add-button">Add Item</button>
    </div>
  </header>
</template>

<script>
export default {
  name: "Header",
};
</script>

<style scoped>
.header-container {
  background-color: #ffecec;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.08);
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.header-title {
  font-size: 24px;
  font-weight: 600;
  color: #742424;
  margin-bottom: 10px;
}

.header-actions {
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
  border: 2px solid #f5aaaa;
  border-radius: 8px;
  padding: 10px 16px;
  font-size: 14px;
  cursor: pointer;
  transition: 0.2s ease;
}

.search-button:hover {
  background-color: #fce1e1;
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