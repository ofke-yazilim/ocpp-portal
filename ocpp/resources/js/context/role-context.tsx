import { createContext, useContext } from 'react';

const RoleContext = createContext<string>('guest'); // varsayılan değer

export const RoleProvider = RoleContext.Provider;

export const useRole = () => useContext(RoleContext);
