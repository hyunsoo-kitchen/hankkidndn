<template>
    <div class="modal-overlay">
      <div class="modal-content">
        <p><slot></slot></p>
        <div class="modal-buttons">
          <button @click="$emit('confirm')">확인</button>
          <button @click="$emit('close')">취소</button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps();
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .modal-content {
    background: white;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
  }
  .modal-buttons {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
  }
  </style>
  