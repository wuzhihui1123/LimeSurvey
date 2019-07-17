import ajax from '../mixins/runAjax.js';
import {LOG} from '../mixins/logSystem.js'

export default {
   getTopBarButtonsQuestion: (context) => {
     return new Promise( (resolve, reject) => {
       ajax.methods.$_get(LS.createUrl('admin/survey/sa/getQuestionTopBar',{ qid: context.state.qid }))
       .then( (data) => {
         context.commit('setTopBar', data.data.topbar);
         context.commit('setPermissions', data.data.permissions);
         resolve();
       })
       .catch( (error) => {
         reject({error: error});
       })
     })
   },

   getTopBarButtonsGroup: (context) => {
     return new Promise( (resolve, reject) => {
       ajax.methods.$_get(LS.createUrl('admin/survey/sa/getQuestionGroupTopBar', { gid: context.state.gid }))
        .then( (data) => {
          context.commit('setTopBar', data.data.topbar);
          context.commit('setPermissions', data.data.permissions);
          resolve();
        })
        .catch( (error) => {
          reject({error: error});
        })
     })
   }
};
