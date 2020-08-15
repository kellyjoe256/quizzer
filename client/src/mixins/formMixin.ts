import Vue from 'vue';
import Joi from 'joi';

interface Error {
    key: string;
    value: string;
}

const errors: Error[] = [];

export default Vue.extend({
    data() {
        return {
            form: {},
            rules: Joi.object({}),
            errors,
        };
    },
    methods: {
        find(field: string) {
            return this.errors.find((e) => e.key === field);
        },
        hasError(field: string): boolean {
            return Boolean(this.find(field));
        },
        getError(field: string): string {
            const error = this.find(field);

            return error ? error.value : '';
        },
        hasErrors(): boolean {
            return Boolean(this.errors.length);
        },
        check(): Error[] {
            const { error: validationError } = this.rules.validate(this.form, {
                abortEarly: false,
                allowUnknown: true,
            });

            if (!validationError) {
                return [];
            }

            const formErrors: Error[] = [];
            validationError.details.forEach((item) => {
                const { context, message } = item;
                if (!context) {
                    return;
                }

                const error = {
                    key: context.key || 'unknown',
                    value: message.replace(/"/g, ''),
                };

                formErrors.push(error);
            });

            return formErrors;
        },
        validate() {
            this.errors = this.check();

            return this.hasErrors();
        },
    },
});
