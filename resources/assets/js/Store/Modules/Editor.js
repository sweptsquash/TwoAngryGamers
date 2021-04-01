import { EDITOR_UPDATE, EDITOR_CLEAR, EDITOR_REMOVE } from '@/Store/Actions/Editor'

export default {
    state: () => ({
        basket: [],
    }),
    mutations: {
        [EDITOR_CLEAR]: (state) => {
            state.basket = []
        },
        [EDITOR_UPDATE]: (state, basket) => {
            state.basket = basket
        },
        [EDITOR_REMOVE]: (state, id) => {
            const index = state.basket.indexOf(id)

            if (index !== 1) {
                state.basket.splice(index, 1)
            }
        },
    },
    actions: {
        [EDITOR_UPDATE]: ({ state, commit }, id) => {
            if (!state.basket.includes(id)) {
                commit(EDITOR_UPDATE, [...state.basket, id])
            } else {
                commit(EDITOR_REMOVE, id)
            }
        },
    },
    getters: {
        isInBasket: (state) => (id) => {
            return state.basket.includes(id)
        },
        getBasket: (state) => state.basket,
    },
}
