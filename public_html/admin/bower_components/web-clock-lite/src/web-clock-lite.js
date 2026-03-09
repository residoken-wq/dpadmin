'use strict';
export default class WebClockLite extends HTMLElement {
  static get observedAttributes() {
    return ['hour', 'minutes'];
  }
  constructor() {
    super();
    this.root = this.attachShadow({mode: 'open'});
    this.root.innerHTML = `
  <style>
    :host {
      display: flex;
      height: 40px;
      align-items: center;
      flex-direction: row;
      padding: 8px;
      box-sizing: border-box;
      color: var(--web-clock-color, #555);
      cursor: default;
    }
    :host([picker]) {
      cursor: pointer;
    })
    :host([picker-opened]) {
      opacity: 0;
      pointer-events: none;
    }
    .hour, .minutes {
      padding: 0 8px;
    }
  </style>
  <div class="hour"></div>
  <span class="indicator">:</span>
  <div class="minutes"></div>
    `;
  }

  get time() {
    return `${this.hour}:${this.minutes}`;
  }

  get hour() {
    return this._hour;
  }

  get minutes() {
    return this._minutes;
  }

  set hour(value) {
    this._applyTimeUpdate('.hour', value);
    this._hour = value;
  }

  set minutes(value) {
    this._applyTimeUpdate('.minutes', value);
    this._minutes = value;
  }

  _applyTimeUpdate(query, value) {
    let target = this.root.querySelector(query);
    requestAnimationFrame(() => {
      target.innerHTML = value;
    });
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (oldValue !== newValue) this[name] = newValue;
  }
}
customElements.define('web-clock-lite', WebClockLite);
