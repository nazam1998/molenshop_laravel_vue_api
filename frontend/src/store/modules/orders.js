export default orders = {
    state: {
        orders: null,
    },
    mutations: {
        setOrders: function (state, value) {
            state.orders = value.data;
        },
    }
}