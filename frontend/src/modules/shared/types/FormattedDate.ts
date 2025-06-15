export class FormattedDate {
    private readonly date: Date
  
    constructor(input: string | Date) {
      if (typeof input === 'string') {
        this.date = new Date(input)
      } else {
        this.date = input
      }
  
      if (isNaN(this.date.getTime())) {
        throw new Error('Invalid date')
      }
    }
  
    toString(locale = 'es-ES', options?: Intl.DateTimeFormatOptions): string {
      return this.date.toLocaleDateString(locale, options ?? {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    }
  
    toDate(): Date {
      return this.date
    }
  
    toISOString(): string {
      return this.date.toISOString()
    }

    toLocaleString(): string {
      return this.date.toLocaleString().replace(',', ' ')
    }
  }
  