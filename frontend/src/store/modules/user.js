import Axios from 'axios'

const API = 'https://recipes.marcfischer.org/api/v1/account/';
const header = {
    'cache-control': 'no-cache',
    Connection: 'keep-alive',
    'content-length': '51',
    'accept-encoding': 'gzip, deflate',
    'Cache-Control': 'no-cache',
    Accept: '*/*',
    'User-Agent': 'recipes-frontend/V0.1.0',
    'Content-Type': 'application/json'
};

const user = {
    //namespaced: true,
    state: {
        id: null,
        email: null,
        token: null,
        name: null,
        tokenLifeTime: null,
        status: null,
        loggedIn: false,

        userModal: false,
        profileModal: false,
        newUserModal: false,
    },

    getters: {
        TOKEN: state => {
            return state.token;
        },
        EMAIL: state => {
            return state.email;
        },
        NAME: state => {
            return state.name;
        },
        TOKENLIFETIME: state => {
            return state.tokenLifeTime;
        },
        STATUS: state => {
            return state.status;
        },
        ISLOGGEDIN: state => {
            return state.loggedIn
        },
        ISPROFILEMODAL: state => {
            return state.profileModal
        },
        ISNEWUSERMODAL: state => {
            return state.newUserModal
        }
    },

    mutations: {
        SET_TOKEN: (state, payload) => {
            state.token = payload;
        },
        SET_EMAIL: (state, payload) => {
            state.email = payload;
        },
        SET_ID: (state, payload) => {
            state.id = payload;
        },
        SET_NAME: (state, payload) => {
            state.name = payload;
        },
        SET_TOKENLIFETIME: (state, payload) => {
            state.tokenLifeTime = payload;
        },
        LOGING_IN: (state, ) => {
            state.status = "LOADING...";
        },
        LOGGED_IN: (state, ) => {
            state.status = "LOGGED IN!";
            state.loggedIn = true;
        },
        LOGGED_OUT: (state, ) => {
            state.status = "LOGGED OUT!";
            state.loggedIn = false;
        },
        LOGIN_ERR: (state, status) => {
            state.status = status;
            state.loggedIn = false;
        },
        TOGGLE_NEWUSERMODAL: (state) => {
            state.userModal = !state.userModal,
            state.newUserModal = !state.newUserModal
        },
        TOGGLE_PROFILEMODAL: (state) => {
            state.userModal = !state.userModal,
            state.profileModal = !state.profileModal
        }
    },

    // see https://github.com/kartoffelfighter/alex-recipies/blob/master/doku/ for api description
    actions: {
        LOG_IN({ commit }, data) {
            return new Promise((resolve, reject) => {
                commit('LOAD')
                Axios({
                    url: API + 'login.php',
                    method: 'POST',
                    header: header,
                    data: JSON.stringify(data)
                })
                    .then(resp => {
                        const token = resp.data.token
                        const lifetime = resp.data.lifetime
                        const id = resp.data.id
                        commit('SET_TOKEN', token)
                        commit('SET_TOKENLIFETIME', lifetime)
                        commit('SET_ID', id)
                        commit('LOGGED_IN')
                        commit('LOAD')
                        commit('DO_NOTIFY', "Login erfolgreich!", 10000)
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('LOGIN_ERR', err)
                        commit('LOAD')
                        reject(err)
                    })
            })
        },
        REGISTER({ commit }, data) {
            return new Promise((resolve, reject) => {
                commit('LOAD')
                Axios({
                    url: API + 'create.php',
                    method: 'POST',
                    header: header,
                    data: JSON.stringify(data)
                })
                    .then(resp => {
                        commit('DO_NOTIFY', "Benutzer wurde angelegt!")
                        resolve(resp)
                    })
                    .catch(err => {
                        commit('DO_NOTIFY', "Fehler beim anlegen des Benutzers!")
                        reject(err)
                    })
            })
        },
        SHOW({commit}, data) {
            return new Promise((resolve, reject) => {
                commit('LOAD')
                Axios({
                    url: API + 'read.php',
                    method: 'POST',
                    header: header,
                    data: JSON.stringify(data)
                })
                .then(resp=>{
                    // eslint-disable-next-line
                    console.log(resp)
                })
                .catch(err => {
                    commit('DO_NOTIFY',"Something went wrong")
                    reject(err)
                })
            })
        }
    }
}

export default user