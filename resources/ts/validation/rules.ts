export const AUTH_RULES = {
  email: [(v: string) => !!v || 'Email is required', (v: string) => /.+@.+\..+/.test(v) || 'Email must be valid'],
  password: [
    (v: string) => !!v || 'Password is required',
    (v: string) => v.length >= 6 || 'Password must be at least 6 characters long',
  ],
}

export const ADD_PRODUCT_RULES = {
  name: [
    (v: string) => !!v || 'Product Name is required',
    // (v: string) => (v && v.length <= 5) || 'Product Name must be less than 100 characters',
  ],
  sku: [
    (v: string) => !!v || 'SKU is required',
    // (v: string) => (v && v.length <= 20) || 'SKU must be less than 20 characters',
  ],
  quantity_in_stock: [
    (v: number) => !!v || 'Quantity in Stock is required',
    (v: number) => v >= 0 || 'Quantity in Stock must be a positive number',
  ],
}

export const ADD_WAREHOUSE_RULES = {
  name: [
    (v: string) => !!v || 'Warehouse Name is required',
    // (v: string) => (v && v.length <= 5) || 'Product Name must be less than 100 characters',
  ],
  location: [
    (v: string) => !!v || 'Location Name is required',
    // (v: string) => (v && v.length <= 5) || 'Product Name must be less than 100 characters',
  ],
}

export const ADD_SUPPLIER_RULES = {
  name: [
    (v: string) => !!v || 'Supplier Name is required',
    // (v: string) => (v && v.length <= 5) || 'Product Name must be less than 100 characters',
  ],
  email: [(v: string) => !!v || 'Email is required', (v: string) => /.+@.+\..+/.test(v) || 'Email must be valid'],
}
