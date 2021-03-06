import * as types from './mutation-types';
import {get } from '../../../helpers/api'

export const getUser = ({ commit, rootState }, id) => {
    commit(types.SET_LOADING, true);

    return new Promise((resolve, reject) => {
        get(`user/${id}`)
            .then(res => {
                commit(types.SET_CURRENT_PAGE_USER, {
                    currentPageUser: res.data.data.currentPageUser,
                    listActivity: res.data.data.listActivity
                })
                commit(types.SET_LOADING, false);
                resolve(res.data.data.currentPageUser)
            })
            .catch(err => {
                commit(types.SET_LOADING, false);
                reject(err)
            })
    })
};

export const loadMore = ({ commit, rootState }, data) => {
    if (data.infoPaginate.to < data.infoPaginate.total) {
        commit(types.SET_LOADING, true);

        return new Promise((resolve, reject) => {
            get(`user/${data.id}?page=${data.infoPaginate.current_page + 1}`)
                .then(res => {
                    commit(types.SET_LIST_ACTIVITY, res.data.data.listActivity);
                    commit(types.SET_LOADING, false);
                    resolve(res.data.data.currentPageUser)
                })
                .catch(err => {
                    commit(types.SET_LOADING, false);
                    reject(err)
                })
        })
    }
};

export default {
    getUser,
    loadMore,
};
