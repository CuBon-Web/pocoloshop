import {HTTP} from '../../core/plugins/http'
import CONSTANTS from '../../core/utils/constants';


export const addVariant = ({commit},opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/variant/create',opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};
export const listVariant = ({commit},opt) => {
    return new Promise((resolve, reject) => {
        HTTP.post('/api/variant/list',opt).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
};

export const deleteVariant = ({commit}, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/variant/delete/'+opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
}
export const detailVariant = ({commit}, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/variant/edit/'+ opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
}

export const listVariantValue = ({commit}, opt) => {
    return new Promise((resolve, reject) => {
        HTTP.get('/api/variant/get-value/'+ opt.id).then(response => {
            return resolve(response.data);
        }).catch(error => {
            return reject(error);
        })
    });
}