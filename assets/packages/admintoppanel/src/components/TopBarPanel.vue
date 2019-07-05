<template>
  <div class="topbarpanel">
    <nav class="navbar navbar-default">
        <div class="collapse navbar-collapse" id="navbar-topbar">
          <ul class="nav navbar-nav">
            <button type="button" class="btn btn-default navbar-btn" href="#"><span class="fa fa-cog"></span>Preview Survey</button>
            <button type="button" class="btn btn-default navbar-btn" href="#"><span class="fa fa-cog"></span>Preview Question Group</button>
            <button type="button" class="btn btn-default navbar-btn" href="#"><span class="fa fa-cog"></span>Preview Question</button>
            <button type="button" class="btn btn-default navbar-btn" href="#"><span class="icon-expressionmanagercheck"></span>Check Logic</button>
            <button type="button" class="btn btn-default navbar-btn" href="#"><span class="fa fa-trash text-danger"></span>Delete</button>
            <button type="button" class="btn btn-default navbar-btn" href="#"><span class="icon-export"></span>Export</button>
            <button type="button" class="btn btn-default navbar-btn" href="#"><span class="icon-copy"></span>Copy</button>
            <button type="button" class="btn btn-default navbar-btn" href="#"><span class="icon-conditions"></span>Set Conditions</button>
            <button type="button" class="btn btn-default navbar-btn" href="#"><span class="icon-defaultanswers"></span>Edit Default answers</button>
          </ul>
        </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: 'TopBarPanel',
  props: ['permissions'],

  mounted() {
    console.log('topbarpanel mounted.');
    console.log(this.permissions);
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

</style>
