export default class BaseComponent {
    constructor(props = {}) {
        this.props = props;
    }

    set(key, value) {
        this.props[key] = value;
    }

    get(key) {
        return this.props[key];
    }

    render() {
        throw new Error("Método render() precisa ser implementado.");
    }
}
