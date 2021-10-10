<template>
  <div>
      <div class="alert alert-primary" role="alert">
        {{ message }}
    </div>
  </div>
</template>

<script>
export default {
  name: "Alert",
  props: ["message"],
};
</script>

<style>
</style>