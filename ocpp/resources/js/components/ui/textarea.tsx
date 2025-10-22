import React from 'react';

interface TextareaProps extends React.TextareaHTMLAttributes<HTMLTextAreaElement> {
    label?: string;
    error?: string;
}

export const Textarea: React.FC<TextareaProps> = ({ label, error, ...props }) => (
    <div className="space-y-1">
        {label && <label className="text-sm font-medium">{label}</label>}
        <textarea
            {...props}
            className="w-full rounded-md border border-gray-300 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700"
        />
        {error && <p className="text-sm text-red-600">{error}</p>}
    </div>
);
