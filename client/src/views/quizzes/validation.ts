import Joi from 'joi';

export const formData = {
    name: '',
    description: '',
};

// prettier-ignore
export const formRules = () => Joi.object({
    name: Joi.string().trim().required().messages({
        'string.empty': 'Name is required',
        'any.required': 'Name is required',
    }),
    description: Joi.string().trim().required().messages({
        'string.empty': 'Description is required',
        'any.required': 'Description is required',
    }),
});
