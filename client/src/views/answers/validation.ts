/* eslint-disable @typescript-eslint/camelcase */
import Joi from 'joi';

export const formData = {
    value: '',
    is_true: false,
};

// prettier-ignore
export const formRules = () => Joi.object({
    value: Joi.string().trim().required().messages({
        'string.empty': 'Answer is required',
        'any.required': 'Answer is required',
    }),
});
