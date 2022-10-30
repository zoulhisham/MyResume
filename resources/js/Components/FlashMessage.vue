<template>
  <main>
    <header></header>
    <content>
      <div v-if="$page.props.flash.message" class="alert">
        {{ $page.props.flash.message }}
      </div>
      <slot />
    </content>
    <footer></footer>
  </main>
</template>