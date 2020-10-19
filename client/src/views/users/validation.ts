/* eslint-disable @typescript-eslint/camelcase */
import Joi from 'joi';

export const formData = {
    name: '',
    email: '',
    password: '123@Pa55',
    is_admin: false,
};

// prettier-ignore
export const formRules = () => Joi.object({
    name: Joi.string().trim().required().messages({
        'string.empty': 'Name is required',
        'any.required': 'Name is required',
    }),
    email: Joi
        .string()
        .trim()
        .required()
        .email({ tlds: false })
        .label('Email')
        .messages({
            'string.empty': 'Email is required',
            'any.required': 'Email is required',
        }),
    // password: Joi.string()
    //     .pattern(/^[A-Za-z@!~#$%^&*()-+\d]{8,}$/)
    //     .messages({
    //         'string.pattern.base': 'Please enter a strong password',
    //     })
    //     .required()
    //     .label('Password'),
    // password_confirmation: Joi.any()
    //     .valid(Joi.ref('password'))
    //     .required()
    //     .options({
    //         messages: {
    //             'any.only': 'Must match password',
    //         },
    //     }),
    // is_admin: Joi.boolean().optional(),
});
