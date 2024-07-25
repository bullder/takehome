'use strict';

class Autocomplete {
	// NOTE: Please do not use any third-party libraries to implement the
	// following as we want to keep the JS payload as small as possible. You may
	// use ES6. There is no need to support IE11.
	//
	// TODO A: Improve the readability of this file through refactoring and
	// documentation. Make any changes you think are necessary.
	/// DONE. Using class implementation seems to me more transparent and understandable

	//
	// TODO B: When typing in the "title" field, we want to auto-complete based on
	// article titles that already exist. You may use the
	// api.php?prefixsearch={search} endpoint for auto-completion. To avoid
	// hitting the server endpoint excessively, please also add JavaScript code
	// that ensures at least 200ms has passed between requests. Check the
	// `design-spec/auto-complete-hover.png` file for the design spec.
	// Also, you don't need to make the autocomplete list disappear when the input
	// has lost focus in this TODO. That will be handled as part of TODO D.
	/// DONE

	//
	// TODO C: When the user selects an item from the auto-complete list, we want
	// the textarea to populate with that article's contents. You may use the
	// api.php?title={title} endpoint to get the article's contents. Check the
	// `design-spec/auto-complete-select.png` file for the design spec.
	/// DONE

	//
	// TODO D: The autocomplete list should only be shown when the input receives
	// focus. The list should be hidden after the user selects an item from the
	// list or after the input loses focus.
	/// DONE

	//
	// TODO E: Figure out how to make multiple requests to the server as the user
	// scrolls through the autocomplete list.
	/// Despite we have debounce functionality for user actions we might met conditions
	/// When visitor is firing multiple calls to backend so we have to cancel previous calls

	//
	// TODO F: Add error-handling requirements, such as displaying error messages
	// to the user when API requests fail and provide a graceful degradation of
	// functionality.
	/// DONE. But for notification simple alerts is used because of time limit

	constructor() {
		this.input = document.getElementById('autocomplete-input');
		this.autocompleteList = document.getElementById('autocomplete-list');
		this.submitButton = document.getElementById('article-submit');
		this.form = document.getElementById('article-form');
		this.textarea = document.getElementById('article-body');

		this.init();
	}

	init() {
		this.initForm();
		this.initAutocomplete();
	}

	initForm() {
		this.submitButton.addEventListener('click', (e) => {
			e.preventDefault();
			this.form.submit();
		});
	}

	initAutocomplete() {
		this.input.addEventListener('input', this.debounce(this.updateSuggestions.bind(this), 300));
		document.addEventListener('click', (e) => {
			if (e.target !== this.input) {
				this.clearAutocompleteList();
			}
		});
	}

	debounce(func, wait) {
		let timeout;
		return function(...args) {
			clearTimeout(timeout);
			timeout = setTimeout(() => func.apply(this, args), wait);
		};
	}

	async fetchApi(query) {
		const controller = new AbortController();
		const timeoutId = setTimeout(() => controller.abort(), 1000);

		try {
			const response = await fetch(query, {signal: controller.signal});
			clearTimeout(timeoutId);

			if (!response.ok) {
				throw new Error('Network response was not ok');
			}

			return await response.json();
		} catch (error) {
			this.handleError(error);
			return [];
		}
	}

	async fetchSuggestions(query) {
		try {
			const data = await this.fetchApi(`/api.php?prefixsearch=${query}`);

			return data.content;
		} catch (error) {
			this.handleError(error);
			return [];
		}
	}

	async updateSuggestions() {
		this.clearAutocompleteList();

		const query = this.input.value.toLowerCase();
		if (!query) return;

		const suggestions = await this.fetchSuggestions(query);

		suggestions.forEach(suggestion => {
			const suggestionItem = document.createElement('div');
			suggestionItem.textContent = suggestion;
			suggestionItem.addEventListener('click', () => {
				this.input.value = suggestion;
				this.clearAutocompleteList();
				this.fetchArticle(suggestion);
			});
			this.autocompleteList.appendChild(suggestionItem);
		});
	}

	clearAutocompleteList() {
		this.autocompleteList.innerHTML = '';
	}

	async fetchArticle(title) {
		try {
			const data = await this.fetchApi(`/api.php?title=${title}`);
			this.textarea.value = data.content.body;
		} catch (error) {
			this.handleError(error);
		}
	}

	handleError(error) {
		if (error.name === 'AbortError') {
			alert('Request timed out');
		} else {
			alert(`Error: ${error.message}`);
		}
	}
}

document.addEventListener("DOMContentLoaded", () => {
	new Autocomplete();
});
