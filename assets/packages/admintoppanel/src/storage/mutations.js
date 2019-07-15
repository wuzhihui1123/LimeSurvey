export default {
    setVisibility: (state, newState) => {
        state.visible = newState;
    },
    setPermissions: (state, newState) => {
      state.permissions = newState;
    },
    setTopBar: (state, newState) => {
      state.topbar = newState;
    },
};
