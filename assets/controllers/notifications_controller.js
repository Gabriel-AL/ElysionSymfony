import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="notifications" attribute will cause
 * this controller to be executed. The name "notifications" comes from the filename:
 * notifications_controller.js -> "notifications"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/notifications_controller.js';
        fetch("").then(function(response){

        }).catch(function(err){
            
        })
    }
}
