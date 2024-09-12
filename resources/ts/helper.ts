export function formatDate(date: Date | string, format: string = 'YYYY-MM-DD'): string {
  if (!(date instanceof Date)) {
    date = new Date(date)
  }
  const options: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    ...parseFormat(format),
  }
  return date.toLocaleDateString(undefined, options)
}

export function formatCurrency(amount: number, currency: string = 'INR'): string {
  return new Intl.NumberFormat(undefined, {
    style: 'currency',
    currency,
  }).format(amount)
}

function parseFormat(format: string): Intl.DateTimeFormatOptions {
  const options: Intl.DateTimeFormatOptions = {}
  if (format.includes('YYYY')) options.year = 'numeric'
  if (format.includes('MM')) options.month = '2-digit'
  if (format.includes('DD')) options.day = '2-digit'
  return options
}

export function formatDateTime(date: Date | string): string {
  if (!(date instanceof Date)) {
    date = new Date(date)
  }

  const day = date.getDate().toString().padStart(2, '0')
  const month = (date.getMonth() + 1).toString().padStart(2, '0')
  const year = date.getFullYear()
  const hours = date.getHours().toString().padStart(2, '0')
  const minutes = date.getMinutes().toString().padStart(2, '0')
  const seconds = date.getSeconds().toString().padStart(2, '0')

  return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`
}
