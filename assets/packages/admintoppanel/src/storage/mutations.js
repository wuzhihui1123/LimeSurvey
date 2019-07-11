export default {
    setVisibility: (state, newState) => {
        state.visible = newState;
    },
    setPermissions: (state, newState) => {
      state.permissions = newState;
    },
    setButtons: (state, newState) => {
      state.buttons = newState;
    },
};
