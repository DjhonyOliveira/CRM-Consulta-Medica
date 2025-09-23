const ComponentRegistry = {};

/** 
 * Realiza o registro de um componente no sistema
 * @param {string} type
 * @param {object} classRef
 * @returns {void}
 */
export function registerComponent(type, classRef) {
    ComponentRegistry[type] = classRef;
}

/**
 * Retorna a instancia do componente de acordo com o json informado
 * @param {string} json 
 * @returns {object}
 * @throws {Error}
 */
export function createComponent(json) {
    const ClassRef = ComponentRegistry[json.type];

    if (!ClassRef) {
        throw new Error(`Componente não registrado: ${json.type}`);
    }

    return new ClassRef(json.props);
}