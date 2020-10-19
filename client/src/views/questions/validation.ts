import Joi from 'joi';

export const formData = {
    text: '',
};

// prettier-ignore
export const formRules = () => Joi.object({
    text: Joi.string().trim().required().messages({
        'string.empty': 'Question is required',
        'any.required': 'Question is required',
    }),
});
