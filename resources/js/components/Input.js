import BaseComponent         from "./BaseComponent.js";
import { registerComponent } from "../ComponentRegistry.js";

/**
 * Classe para geração do component input do sistema
 * @author Djonatan R. de Oliveira
 */
class Input extends BaseComponent {
    constructor(){
        this.setLabel(this.props['label']);
        this.setName(this.props['name']);
        this.setPlaceholder(this.props['placeholder']);
        this.setReadOnly(this.props['readOnly']);
        this.setRequired(this.props['required']);
        this.setType(this.props['type']);
        this.setValue(this.props['value']);
    }

    setType(type){
        this.type = type;
    }

    getType(){
        return this.type;
    }

    setName(name){
        this.name = name;
    }

    getName(){
        return this.name;
    }

    setValue(value){
        this.value = value;
    }

    getValue(){
        return this.value;
    }

    setPlaceholder(placeholder){
        this.placeholder = placeholder;
    }

    getPlaceholder(){
        return this.placeholder;
    }

    setReadOnly(readOnly){
        this.readOnly = readOnly;
    }

    getReadOnly(){
        return this.readOnly;
    }

    setRequired(required){
        this.required = required;
    }

    getRequired(){
        return this.required;
    }

    setLabel(label){
        this.label = label;
    }

    getLabel(){
        return this.label;
    }

    render() {
        return `
            <div class="form-group">
                <label for="${this.getName()}">${this.getLabel()}</label>
                <input type="text"
                       name="${this.getName()}" 
                       value="${this.getValue()}"
                       placeholder="${this.getPlaceholder()}"
                       ${this.getRequired() ? "required" : ""}
                       ${this.getReadOnly() ? "readonly" : ""}>
            </div>
        `;
    }
}

registerComponent("input", Input);

export default Input;
